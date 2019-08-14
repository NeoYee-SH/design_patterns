<?php
/**
 * Created by PhpStorm.
 * User: Appla
 * Date: 2017/5/5
 * Time: 13:58
 */

namespace test;

use Error;
use DateTime;
use Redis;
use Closure;
use Exception;
use Generator;
use OutOfBoundsException;
use BadMethodCallException;
use function sprintf, arsort, printf, strtr, preg_grep, round, count, implode, array_slice, range, array_filter, strpos;
use const PHP_EOL;

/**
 * Class RedisKeyUtil
 * @package test
 *
 * @method void typeFilter()
 * @method void ttlFilter()
 * @method void valueFilter()
 */
class RedisKeyUtil
{
    /**
     * @var mixed
     */
    private const
        BATCH_SIZE = 2222,
        KEY_PATTERN = '*',
        SHOULD_DELETE = true,
        DAY_SECONDS = 86400,
        KEY_SAMPLE = 'KEY_SAMPLE',
        MATCH_ALL_KEY_PATTERN = '*';

    /**
     * @var int
     */
    private const
        FILTER_TYPE_TTL = 1,
        FILTER_TYPE_VALUE = 2,
        FILTER_TYPE_TYPE = 4;

    /**
     * 数据级别
     * @var int
     */
    private const
        SIZE_BYTE = 1,
        SIZE_KB = self::SIZE_BYTE ** 2,
        SIZE_MB = self::SIZE_KB ** 2,
        SIZE_GB = self::SIZE_MB ** 2,
        SIZE_TB = self::SIZE_GB ** 2,
        SIZE_10KB = self::SIZE_KB * 10;

    /**
     * 扫描
     * @var string
     */
    private const
        SCAN_TYPE_KEY = 'scan',
        SCAN_TYPE_SET = 'sScan',
        SCAN_TYPE_HASH = 'hScan',
        SCAN_TYPE_SORTED_SET = 'zScan';

    /**
     * 删除
     * @var array
     */
    private const
        REMOVE_KEY_MAP = [
//            self::SCAN_TYPE_KEY => 'unlink',
        self::SCAN_TYPE_SET => 'sRem',
        self::SCAN_TYPE_HASH => 'hDel',
        self::SCAN_TYPE_SORTED_SET => 'zRem',
    ];

    /**
     * @var string
     */
    public const
        TYPE_CLUSTER = 'cluster',
        TYPE_REDIS_HASH = 'redis_hash',
        TYPE_REDIS_SET = 'redis_set',
        TYPE_REDIS_SORTED_SET = 'redis_sorted_set',
        TYPE_ALI_CLUSTER = 'ali_cluster',
        TYPE_STAND_ALONE = 'stand_alone';

    /**
     * @var array
     */
    private const TYPED_KEY_MAP = [
        self::TYPE_REDIS_HASH => Redis::REDIS_HASH,
        self::TYPE_REDIS_SET => Redis::REDIS_SET,
        self::TYPE_REDIS_SORTED_SET => Redis::REDIS_ZSET,
    ];

    /**
     * filter types
     * @var array
     */
    private const FILTER_TYPE = [
        self::FILTER_TYPE_TTL => 'filterByTTL',
        self::FILTER_TYPE_TYPE => 'filterByType',
        self::FILTER_TYPE_VALUE => 'filterByValue',
    ];

    /**
     * @var array
     */
    public const REDIS_TYPE_MAP = [
        Redis::REDIS_STRING => 'string',
        Redis::REDIS_SET => 'set',
        Redis::REDIS_LIST => 'list',
        Redis::REDIS_ZSET => 'zset',
        Redis::REDIS_HASH => 'hash',
        Redis::REDIS_NOT_FOUND => 'not found',
    ];

    /**
     * @var array
     */
    private $clusterNodes = [];

    /**
     * @var int
     */
    private $currentNodeCount = 0;

    /**
     * @var string
     */
    private $currentKeyName;

    /**
     * @var int
     */
    private $currentKeyType;

    /**
     * @var string
     */
    private $currentValue;

    /**
     * @var int
     */
    private $currentKeyLength;

    /**
     * @var int
     */
    private $currentKeyTtl;

    /**
     * @var int
     */
    private $scanCursor;

    /**
     * @var array
     */
    private $targetKeys = [];

    /**
     * @var array
     */
    private $lastQueryKeys = [];

    /**
     * @var int
     */
    private $scanInterval = 10000;

    /**
     * type filter
     *
     * @var callable
     */
    private $typeFilter;

    /**
     * ttl filter
     *
     * @var callable
     */
    private $ttlFilter;

    /**
     * value filter
     *
     * @var callable
     */
    private $valueFilter;

    /**
     * @var bool
     */
    private $noFilterSet = true;

    /**
     * @var int
     */
    private $totalLimit = PHP_INT_MAX;

    /**
     * @var int
     */
    private $limit = self::BATCH_SIZE;

    /**
     * @var string
     */
    private $keyPattern = self::KEY_PATTERN;

    /**
     * @var Redis
     */
    private $redis;

    /**
     * @var string
     */
    private $redisTargetType = self::TYPE_STAND_ALONE;

    /**
     * @var Generator
     */
    private $clusterNodeKeyScannerIterator;

    /**
     * @var Generator
     */
    private $keyScannerIterator;

    /**
     * @var int
     */
    private $matchedType;

    /**
     * @var bool
     */
    private $enableReverseFilter = false;

    /**
     * @var bool
     */
    private $enableReverseKey = false;

    /**
     * @var int
     */
    private $dbIndex = 0;

    /**
     * @var int
     */
    private $processed = 0;

    /**
     * @var int
     */
    private $dbSize;

    /**
     * @var string
     */
    private $typedScanKey;

    /**
     * @var int
     */
    private $typedKeyType;

    /**
     * @var int
     */
    private $typedKeySize;

    /**
     * @var Generator[]
     */
    private $typedKeyGenerator = [];

    /**
     * @var bool
     */
    private $typedScanRemoveKeyOption;

    /**
     * @var array
     */
    private $ttlAnalysisArr = [];

    /**
     * @var array
     */
    private $sizeAnalysisArr = [];

    /**
     * @var array
     */
    private $keyHistory = [];

    /**
     * RedisMigration constructor.
     * @param Redis $redis
     */
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * 扫描key, 加速过期
     * @return void
     * @throws Exception
     */
    public function accelerateKeyGC()
    {
        while ($this->getKeys()) {
            $this->progressInfo();
        }
        echo 'done', \PHP_EOL;
    }

    /**
     *  data cleaner
     * @throws Exception
     */
    public function clean()
    {
        while($this->getKeys()){
            foreach ($this->lastQueryKeys as $key) {
                $this->currentKeyName = $key;
                if($this->shouldDelete($key)){
                    printf('key:%s ,is matched with filter you set[%s] and will delete soon' . PHP_EOL, $key, $this->matchedType ? self::FILTER_TYPE[$this->matchedType] : '');
                    $this->targetKeys[] = $key;
                } else{
                    printf('key:%s, ttl:%s' . PHP_EOL, $key, $this->currentKeyTtl);
                }
            }
            $this->progressInfo();
        }
        $this->targetKeys && $this->cleanTargetKeys(true);
    }

    /**
     * 分析ttl
     * @param int $batchSize
     * @param int $sampleSize
     * @return array
     * @throws Exception
     */
    public function analysisTtl($batchSize = 1000, int $sampleSize = 10)
    {
        $tmpArr = &$this->ttlAnalysisArr;
        foreach ($this->keysTtlIterator($batchSize) as ['keys' => $keys, 'result' => $result]) {
            foreach ($result as $idx => $ttl) {
                if ($ttl >= self::DAY_SECONDS) {
                    $key = (int)($ttl / self::DAY_SECONDS);
                    $humanReadableTime = ($ttl / self::DAY_SECONDS) . '天';
                } else {
                    $key = $ttl === -1 ? 'forever' : 'lessThanOneDay';
                    if ($ttl < 0) {
                        $humanReadableTime = $ttl;
                    } else {
                        $humanReadableTime = $ttl > 3600 ? ($ttl / 3600) . '小时' : ($ttl / 60) . '分';
                    }
                }
                (isset($tmpArr[$key]) && $tmpArr[$key]++) || $tmpArr[$key] = 1;
                (isset($tmpArr[self::KEY_SAMPLE][$key]) && \count($tmpArr[self::KEY_SAMPLE][$key]) > $sampleSize) || (!$this->isSimilarWithHistory($keys[$idx], __FUNCTION__) && $tmpArr[self::KEY_SAMPLE][$key][$keys[$idx]] = $humanReadableTime);
            }
        }
        arsort($this->ttlAnalysisArr, \SORT_NUMERIC);
        print_r($this->ttlAnalysisArr);
        return $this->ttlAnalysisArr;
    }

    /**
     * 分析key的大小
     * @param int $batchSize
     * @param int $sampleSize
     * @return array
     * @throws \Exception
     */
    public function analysisSize($batchSize = 1000, int $sampleSize = 10)
    {
        $tmpArr = &$this->sizeAnalysisArr;
        $unitArray = ['B','KiB','MiB','GiB','TiB','PiB'];
        $levelArray = [1 => '<10', '>10&&<100', '>100&&<1000', '>1000&&<1024'];
        foreach ($this->keysSizeIterator($batchSize) as ['keys' => $keys, 'result' => $result]) {
            foreach ($result as $idx => $size) {
                $formattedSize = round($size / 1024 ** ($unitIdx = floor(log($size, 1024))), 4);
                $intSize = (int)$formattedSize;
                $unit = $unitArray[(int)$unitIdx];
                $key = $levelArray[\strlen((string)($intSize))] . '_' . $unit;
                isset($tmpArr[$key]) && $tmpArr[$key]++ or $tmpArr[$key] = 1;
                (isset($tmpArr[self::KEY_SAMPLE][$key]) && \count($tmpArr[self::KEY_SAMPLE][$key]) > $sampleSize) || (!$this->isSimilarWithHistory($keys[$idx], __FUNCTION__) && $tmpArr[self::KEY_SAMPLE][$key][$keys[$idx]] = $formattedSize . $unit);
            }
        }
        arsort($this->sizeAnalysisArr, \SORT_NUMERIC);
        print_r($this->sizeAnalysisArr);
        return $this->sizeAnalysisArr;
    }

    /**
     * 假定没有多字节的值存在
     *
     * @param string $key
     * @param string $type
     * @param int $minNum
     * @return bool
     */
    private function isSimilarWithHistory(string $key, string $type, int $minNum = 5): bool
    {
        $keyPrefix = \substr($key, 0, (int)(\strlen($key) / 2));
        $hasNum = ($this->keyHistory[$type][$keyPrefix] = ($this->keyHistory[$type][$keyPrefix] ?? 0) + 1);
        return $hasNum > $minNum;
    }

    /**
     *
     * @param int $batchSize
     * @param callable $func
     * @param bool $sortResultByKey
     * @return array
     * @throws \InvalidArgumentException
     */
    public function batchCleanByTtl(callable $func = null, int $batchSize = 1000,  bool $sortResultByKey = false)
    {
        $func or $func = $this->ttlFilter;
        $ret = [];
        if (\is_callable($func)) {
            foreach ($this->keysTtlIterator($batchSize) as ['keys' => $keys, 'result' => $result]) {
//                $sortResultByKey && \ksort($keys, \SORT_NUMERIC);
//                $sortResultByKey && \ksort($result, \SORT_NUMERIC);
                $ret[] = $func(\array_combine(\array_values($keys), \array_values($result)));
            }
        } else {
            throw new \InvalidArgumentException('未设置TTL handler');
        }
        return $ret;
    }

    /**
     * @note 支持Redis 4.0
     * @param int $batchSize
     * @return array
     * @throws \Exception
     */
    public function keysSizeIterator(int $batchSize = 1000)
    {
        return $this->keysIterator(function(string $key, Redis $pipe) {
            $pipe->rawCommand('memory', 'usage', $key);
        }, $batchSize);
    }

    /**
     * 针对key的批量处理, 需要传入一个回调
     * @param callable $func 接收两个参数, func(string $key, Redis $r = null)
     * @param int $batchSize
     * @return array
     * @throws Exception
     */
    public function keysIterator(callable $func, int $batchSize = 1000)
    {
        while($this->getKeys()){
            foreach (\array_chunk($this->lastQueryKeys, $batchSize) as $keys) {
                $pipe = $this->redis->multi(Redis::PIPELINE);
                foreach ($keys as $key) {
                    $func($key, $pipe);
//                    $pipe->rawCommand('memory', 'usage', $key);
                }
                if ($result = $pipe->exec()) {
                    yield ['keys' => $keys, 'result' => $result];
                }
            }
            $this->progressInfo();
        }
        return [];
    }

    /**
     *
     * @param int $batchSize
     * @return array
     * @throws Exception
     */
    public function keysTtlIterator(int $batchSize = 1000)
    {
        return $this->keysIterator(function(string $key, Redis $pipe) {
            $pipe->ttl($key);
        }, $batchSize);
    }

    /**
     * @param callable $func
     * @return array
     * @throws Exception
     */
    public function handleByClosure(callable $func)
    {
        $result = [];
        $func = Closure::bind($func, $this, self::class);
        while($this->getKeys()){
            $result[] = $func($this->lastQueryKeys);
            $this->progressInfo();
        }
        return $result;
    }

    /**
     * 分析 bigkeys
     * @param int $keyLength
     * @return array
     * @throws Exception
     */
    public function analysisBigKeys(int $keyLength = 5120)
    {
        $matchedKeys = [];
        while($this->getKeys()){
            foreach ($this->lastQueryKeys as $key) {
                $this->currentKeyName = $key;
                if ($this->getKeyLength() < $keyLength) {
                    continue;
                }
                $matchedKeys[$key] = $this->currentKeyLength;
                printf('current node: %s, key[%s]: %s, length: %s' . PHP_EOL, $this->currentNodeCount, self::REDIS_TYPE_MAP[$this->currentKeyType] ?? 'UNKNOWN', $key, $this->currentKeyLength);
            }
            $this->progressInfo();
        }
        print_r($matchedKeys);
        return $matchedKeys;
    }

    /**
     * @param int $processed
     * @return bool
     * @throws OutOfBoundsException
     */
    private function checkLimit(int $processed) : bool
    {
        if ($this->totalLimit > $processed) {
            return true;
        }
        throw new OutOfBoundsException(sprintf('已处理%d超出最大限制%d', $processed, $this->totalLimit));
    }

    /**
     * shouldDelete
     *
     * @param  string $key
     * @return bool
     */
    private function shouldDelete(string $key = null)
    {
        $key || $key = $this->currentKeyName;
        $result = ($this->noFilterSet && self::SHOULD_DELETE) or  $this->ttlFilter && ($this->ttlFilter)($this->getTtl($key)) && $this->matchedType = self::FILTER_TYPE_TTL or $this->typeFilter && ($this->typeFilter)($this->getType($key)) && $this->matchedType = self::FILTER_TYPE_TYPE or $this->valueFilter && ($this->valueFilter)($this->getValue($key)) && $this->matchedType = self::FILTER_TYPE_VALUE;
        return $this->enableReverseFilter ? !$result : $result;
    }

    /**
     * @return array|bool
     * @throws Exception
     */
    private function getKeys()
    {
        switch ($this->redisTargetType) {
            case self::TYPE_REDIS_HASH:
                $this->lastQueryKeys = ($this->typedKeyGenerator[$this->typedScanKey] ?? $this->typedKeyGenerator[$this->typedScanKey] = $this->hashScanIterator($this->typedScanKey, $this->limit, $this->keyPattern, $this->typedScanRemoveKeyOption))->send(null);
                break;
            case self::TYPE_REDIS_SET:
                $this->lastQueryKeys = ($this->typedKeyGenerator[$this->typedScanKey] ?? $this->typedKeyGenerator[$this->typedScanKey] = $this->setScanIterator($this->typedScanKey, $this->limit, $this->keyPattern, $this->typedScanRemoveKeyOption))->send(null);
                break;
            case self::TYPE_REDIS_SORTED_SET:
                $this->lastQueryKeys = ($this->typedKeyGenerator[$this->typedScanKey] ?? $this->typedKeyGenerator[$this->typedScanKey] = $this->zSetScanIterator($this->typedScanKey, $this->limit, $this->keyPattern, $this->typedScanRemoveKeyOption))->send(null);
                break;
            case self::TYPE_ALI_CLUSTER:
                $this->lastQueryKeys = $this->nodeScanKeys();
                break;
            case self::TYPE_CLUSTER:
                throw new BadMethodCallException('暂未实现redis cluster scan');
                break;
            case self::TYPE_STAND_ALONE:
            default:
                $this->lastQueryKeys = $this->enableReverseKey ? $this->getKeysReverse() : $this->scanKeys();

        }
        return $this->lastQueryKeys;
    }

    /**
     * @return array|bool
     */
    private function scanKeysOld()
    {
        $keys = [];
        while(!$keys && $this->scanCursor !== 0){
            $keys = $this->redis->scan($this->scanCursor, $this->keyPattern, $this->limit);
            $this->usleep();
        }
        return $keys;
    }

    /**
     * @return mixed
     */
    private function scanKeys()
    {
        return ($this->keyScannerIterator ?? $this->keyScannerIterator = $this->scanKeysIterator())->send(null);
    }

    /**
     * @TODO 内部用, 使用send, 先发无用的数据!
     * @return array|\Generator
     */
    private function scanKeysIterator()
    {
        yield [];
        do {
            if ($keys = $this->redis->scan($this->scanCursor, $this->keyPattern, $this->limit)) {
                yield $keys;
                $keys = [];
            }
            $this->usleep();
        } while(!$keys && $this->scanCursor !== 0);
        return [];
    }

    /**
     * @return array|bool
     */
    private function nodeScanKeys()
    {
        return ($this->clusterNodeKeyScannerIterator ?? $this->clusterNodeKeyScannerIterator = $this->nodeScanKeysIterator())->send(null);
    }

    /**
     * @return \Generator
     */
    private function nodeScanKeysIterator()
    {
        //直接用send获取值.
        yield [];
        foreach ($this->clusterNodes as $nodeCount) {
            $this->scanCursor = '0';
            $this->currentNodeCount = $nodeCount;
            do {
                [$this->scanCursor, $keys] = $this->redis->rawCommand('iscan', (string)$nodeCount, $this->scanCursor, 'MATCH', $this->keyPattern, 'COUNT', (string)$this->limit);
                if ($keys) {
                    yield $keys;
                    $keys = [];
                }
                if ($this->scanCursor === null) {
                    throw new BadMethodCallException('无效的调用!redis实例不是aliyun的');
                }
                $this->usleep();
            } while(!$keys && $this->scanCursor !== '0');
        }
    }

    /**
     * get keys by reverse pattern
     *
     * @return array
     */
    private function getKeysReverse()
    {
        if($this->keyPattern === self::MATCH_ALL_KEY_PATTERN){
            return [];
        }
        $matchedKeys = [];
        $pattern = strtr($this->keyPattern, [
            '?' => '.',
            '*' => '.+',
        ]);
        while(!$matchedKeys && $this->scanCursor !== 0) {
            if($keys = $this->redis->scan($this->scanCursor, self::MATCH_ALL_KEY_PATTERN, $this->limit)){
                $matchedKeys = preg_grep(sprintf('~%s~u', $pattern), $keys, PREG_GREP_INVERT);
//                $pattern = rtrim($this->keyPattern, '*');
//                $matchedKeys = array_filter($keys, function($key) use($pattern) {
//                    return strpos($key, $pattern) === 0;
//                });
            }
            $this->usleep();
        }
        return $matchedKeys;
    }

    /**
     * @param int|null $interval
     */
    private function usleep(int $interval = null)
    {
        \usleep($interval ?? $this->scanInterval);
    }

    /**
     * @param string $key
     * @return int
     */
    private function getType(string $key = null)
    {
        return $this->currentKeyType = $this->redis->type($key ?: $this->currentKeyName);
    }

    /**
     * @param string|null $key
     * @return int
     */
    private function getTtl(string $key = null)
    {
        return $this->currentKeyTtl = $this->redis->ttl($key ?: $this->currentKeyName);
    }

    /**
     * @TODO 优化数据量大的情况
     * @param string $key
     * @return int
     */
    private function getValue(?string $key = null)
    {
        $key || $key = $this->currentKeyName;
        switch ($this->getType($key)){
            case Redis::REDIS_STRING:
                $value = $this->redis->get($key);
                break;
            case Redis::REDIS_SET:
                $value = $this->redis->sGetMembers($key);
                break;
            case Redis::REDIS_LIST:
                $value = $this->redis->lRange($key, 0, -1);
                break;
            case Redis::REDIS_ZSET:
                $value = $this->redis->zRange($key, 0, -1);
                break;
            case Redis::REDIS_HASH:
                $value = $this->redis->hGetAll($key);
                break;
            case Redis::REDIS_NOT_FOUND:
            default:
                $value = null;
        }
        return isset($value) ? $this->currentValue = $value : null;
    }

    /**
     * @param string $key
     * @return int
     */
    private function getKeyLength(?string $key = null, int $type = null)
    {
        $key || $key = $this->currentKeyName;
        switch ($type ?? $this->getType($key)){
            case Redis::REDIS_STRING:
                $length = strlen($this->redis->get($key) ?? '');
                break;
            case Redis::REDIS_SET:
                $length = $this->redis->sCard($key);
                break;
            case Redis::REDIS_LIST:
                $length = $this->redis->lLen($key);
                break;
            case Redis::REDIS_ZSET:
                $length = $this->redis->zCard($key);
                break;
            case Redis::REDIS_HASH:
                $length = $this->redis->hLen($key);
                break;
            case Redis::REDIS_NOT_FOUND:
            default:
                $length = 0;
        }
        return $this->currentKeyLength = $length;
    }

    /**
     * cleanTargetKeys
     *
     * @param bool $force
     * @return int
     */
    private function cleanTargetKeys(?bool $force = false)
    {
        $ret = 0;
        if(($force && $this->targetKeys) || count($this->targetKeys) > $this->limit){
            $ret = $this->redis->del(...$this->targetKeys) and printf('%d keys are deleted.[%s...]'. PHP_EOL, count($this->targetKeys), implode(', ', array_slice($this->targetKeys, 0, 5)));
            $this->targetKeys = [];
        }
        return $ret;
    }

    /**
     * @param string $key
     * @param int $count
     * @param string $pattern
     * @param bool $removeKey
     * @return Generator
     * @throws Exception
     */
    public function zSetScanIterator(string $key, int $count = 1000, string $pattern = '*', bool $removeKey = false)
    {
        return $this->scanIterator($key, $count, $pattern, $removeKey, self::SCAN_TYPE_SORTED_SET);
    }

    /**
     * @param string $key
     * @param int $count
     * @param string $pattern
     * @param bool $removeKey
     * @return Generator
     * @throws Exception
     */
    public function setScanIterator(string $key, int $count = 1000, string $pattern = '*', bool $removeKey = false)
    {
        return $this->scanIterator($key, $count, $pattern, $removeKey, self::SCAN_TYPE_SET);
    }

    /**
     * @param string $key
     * @param int $count
     * @param string $pattern
     * @param bool $removeKey
     * @return Generator
     * @throws Exception
     */
    public function hashScanIterator(string $key, int $count = 1000, string $pattern = '*', bool $removeKey = false)
    {
        return $this->scanIterator($key, $count, $pattern, $removeKey, self::SCAN_TYPE_HASH);
    }

    /**
     * @param string $key
     * @param int $count
     * @param string $pattern
     * @param bool $removeKey
     * @return Generator
     * @throws Exception
     */
    private function scanIterator(string $key, int $count = 1000, string $pattern = '*', bool $removeKey = false, string $command = self::SCAN_TYPE_HASH)
    {
        //针对利用send调用的patch
        yield [];
        $this->scanCursor = null;
        $redisInstance = $this->redis;
        $command && isset(self::REMOVE_KEY_MAP[$command]) or die('不支持的指令!' . $command);
        $delCommand = self::REMOVE_KEY_MAP[$command];
        do {
            if ($result = $redisInstance->$command($key, $this->scanCursor, $pattern, $count)) {
                $removeKey && $redisInstance->$delCommand($key, ...$result);
                yield $result;
            }
            $this->progressInfo();
        } while ($this->scanCursor !== 0);
        return [];
    }

    /**
     * @param int|null $processed
     * @return void
     * @throws Exception
     */
    private function progressInfo(int $processed = null)
    {
        $total = $this->typedScanKey ? $this->getTypedKeySize() : $this->getDbSize();
        $this->processed += $processed ?? \count($this->lastQueryKeys);
        printf('正在处理中....,共有%s,已处理%s -- %s%%' . PHP_EOL, $total, $this->processed, $total > 0 ? \round($this->processed / $total, 4) * 100 : 100);
        try {
            $this->checkLimit($this->processed);
        } catch (Exception $e) {
            echo $e->getMessage(), PHP_EOL;
            throw $e;
        }
    }

    /**
     * @return int
     */
    private function getDbSize()
    {
        return $this->dbSize ?? $this->dbSize = $this->redis->dbSize();
    }

    /**
     * @return int
     */
    private function getTypedKeySize() : int
    {
        return $this->typedKeySize ?? $this->typedKeySize = $this->getKeyLength($this->typedScanKey, $this->getTypedKeyType());
    }

    /**
     * @return int
     */
    private function getTypedKeyType() : int
    {
        return $this->typedKeyType ?? $this->typedKeyType = $this->getType($this->typedScanKey);
    }

    /**
     * @param string $key
     * @param string|null $type
     * @param bool $removeKey
     * @return $this
     */
    public function asTypedKeyScan(string $key, string $type = null, bool $removeKey = false)
    {
        if (!$key || ($keyType = $this->getType($key)) === Redis::REDIS_NOT_FOUND) {
            throw new \InvalidArgumentException('无效的key!');
        }
        if (($type === null && !$type = \array_flip(self::TYPED_KEY_MAP)[$keyType] ?? null) || (!isset(self::TYPED_KEY_MAP[$type]) || $keyType !== self::TYPED_KEY_MAP[$type])) {
            throw new \InvalidArgumentException('无效的key类型!');
        }
        $this->typedKeyType = $keyType;
        $this->redisTargetType = $type;
        $this->typedScanKey = $key;
        $this->typedScanRemoveKeyOption = $removeKey;
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit)
    {
        if($limit > 0){
            $this->limit = $limit;
        }
        return $this;
    }

    /**
     * @param int $dbIdx
     * @return $this
     */
    public function setRedisDb(int $dbIdx)
    {
        $this->dbIndex = $dbIdx;
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setTotalLimit(int $limit)
    {
        $limit > 0 && $this->totalLimit = $limit;
        return $this;
    }

    /**
     * @param string $pattern
     * @return $this
     */
    public function pattern(string $pattern)
    {
        if($pattern){
            $this->keyPattern = $pattern;
        }
        return $this;
    }

    /**
     * setTtlFilter
     * @return $this
     */
    public function setTtlFilter(callable $func)
    {
        $this->ttlFilter = $func;
        $this->noFilterSet = false;
        return $this;
    }

    /**
     * setTypeFilter
     * @return $this
     */
    public function setTypeFilter(callable $func)
    {
        $this->typeFilter = $func;
        $this->noFilterSet = false;
        return $this;
    }

    /**
     * setValueFilter
     * @return $this
     */
    public function setValueFilter(callable $func)
    {
        $this->valueFilter = $func;
        $this->noFilterSet = false;
        return $this;
    }

    /**
     * @param int $interval
     * @return $this
     */
    public function setScanInterval(int $interval)
    {
        $interval > 0 && $this->scanInterval = $interval;
        return $this;
    }

    /**
     * @return $this
     */
    public function setAsCluster()
    {
        $this->redisTargetType = self::TYPE_CLUSTER;
        return $this;
    }

    /**
     * @TODO check if is ali redis by nodecount
     * @return $this
     */
    public function setAsAliCluster()
    {
        $this->redisTargetType = self::TYPE_ALI_CLUSTER;
        $this->clusterNodes = range(0, ($this->redis->info()['nodecount'] ?? 1) - 1);
        $nodeCount = \count($this->clusterNodes);
        assert($nodeCount > 4, '可能不是有效的ali集群, node总数为' . $nodeCount);
        return $this;
    }

    /**
     * enable reverse filter
     * @return $this
     */
    public function reverseFilter()
    {
        $this->enableReverseFilter = true;
        return $this;
    }

    /**
     * enable reverse key
     * @return $this
     */
    public function reverseKey()
    {
        $this->enableReverseKey = true;
        return $this;
    }
}

$src = $dst = null;
/*$CLOSURES = [
    'MIGRATION' => function(array $keys) use($src, $dst) {
        printf('找到%d个key, keys: %s' . PHP_EOL, count($keys), implode(', ', $keys));
        usleep(10000);
        $pipe = $r->pipeline();
        foreach ($keys as $key) {
            $pipe->ttl($key);
        }
        if ($result = $pipe->exec()) {
            $result = \array_combine($keys, $result);
        }
        $total = \count($result);
        $successTotal = 0;
        foreach ($result as $key => $ttl) {
            $raw = $r->dump($key);
            $dst->del($key);
            $dst->restore($key, $ttl, $raw) && $successTotal++;
        }
        echo '成功:', $successTotal, ' ,总数:', $total, PHP_EOL;
    },
];*/



$r = new Redis();
$redisConfig = [
    '192.168.1.77',
    6380,
    1
];
$authCode = '';

try {
    $r->connect(...$redisConfig);
    if (!empty($authCode) && !$r->auth($authCode)) {
        throw new \InvalidArgumentException('验证错误!');
    }
} catch(Exception | Error $e) {
    echo 'exception catched', $e->getMessage(), PHP_EOL;
    exit($e->getCode());
}

error_reporting(E_ALL);
ini_set('memory_limit', -1);

$dstConfig = [
    '127.0.0.1',
    6380,
    1
];
$dstAuth = '';

$dst = new Redis();
try {
    $dst->connect(...$dstConfig);
} catch (Exception $e) {
    echo 'FAILED TO CONNECT TO DST REDIS SERVER!:', $e->getMessage(), PHP_EOL;
}
if (!empty($dstAuth) && !$dst->auth($dstAuth)) {
    throw new \InvalidArgumentException('验证错误!');
}

$pattern = '*';
$specialKey = '';
try {
    (new RedisKeyUtil($r))
//        ->setAsAliCluster()
        ->limit(1000)
        ->setScanInterval(1000)
//        ->asTypedKeyScan($specialKey)
        // ->limit(3000)
        ->setTotalLimit(50000000)
//        ->setTotalLimit(5000)
        ->pattern($pattern)
//        ->accelerateKeyGC();
//    ->clean();
//           ->handleByClosure(function(array $keys) use($r, $dst) {
//           printf('找到%d个key, keys: %s' . PHP_EOL, count($keys), implode(', ', array_slice($keys, 0, 5)));
//            /**
//             * @var \Redis $r
//             * @var \Redis $pipe
//             * @var \Redis $dst
//             */
////           $pipe = $r->pipeline();
////           foreach ($keys as $key) {
////               $pipe->ttl($key);
////           }
////           if ($result = $pipe->exec()) {
////               $result = \array_combine($keys, $result);
////    //           $result = \array_combine($keys, array_map('json_encode', $result));
////           }
////           $result = array_filter($result, function($ttl){
////                return $ttl === -1 || $ttl > 4000;
////           });
//    //       $pipe = $r->pipeline();
//    //       foreach ($result as $key => $val) {
//    //           $key = \str_replace('wduser:login:session_', 'wduser:login:_session_', $key);
//    //           $pipe->setex($key, 86400 * 5, $val);
//    //       }
//    //       $pipe->exec();
//    //       exit;
//             $successTotal = 0;
//             $result = \array_fill_keys($keys, 86400 * 5);
//             $total = \count($result);
//             foreach (\array_chunk($result, 500, true) as $subSet) {
//                 $r->multi(Redis::PIPELINE);
//                 $tmpKeys = [];
//                 foreach ($subSet as $key => $ttl) {
//                     $tmpKeys[] = $key;
//                     $r->dump($key);
//                 }
//                 if ($rawSet = $r->exec()) {
//                     $dst->del(...$tmpKeys);
//                     $dst->multi(Redis::PIPELINE);
//                     foreach (\array_combine($tmpKeys, $rawSet) as $key => $raw) {
// //                        echo $key, ' : ' , $ttl = $subSet[$key], PHP_EOL;
//                         $dst->restore($key, $ttl < 0 ? 0 : $ttl * 1000, $raw);
//                     }
//                     $successTotal += \array_sum($dst->exec());
//                 } else {
//                     echo '执行失败!', PHP_EOL;
//                 }
//             }

//           foreach ($result as $key => $ttl) {
//               echo $key, ' : ' , $ttl, PHP_EOL;
//               $raw = $r->dump($key);
////               $dst->del($key);
//               $dst->restore($key, $ttl < 0 ? 0 : $ttl * 1000, $raw, true) && $successTotal++;
//           }
//
//           echo '成功:', $successTotal, ' ,总数:', $total, PHP_EOL;
////           exit;
//       });

//
//       ->handleByClosure(function(array $keys) use($r, $specialKey, $dst) {
//            $keys = array_filter($keys, function($key){
//                return strpos($key, 'no_save') === 0;
//            });
//            if (!$keys) {
//                return 0;
//            }
//            printf('找到%d个key, keys: %s' . PHP_EOL, count($keys), implode(', ', array_slice($keys, 0, 5)));
//
//            $ret = $keys;
//            count($keys) && $r->del(...$keys);
////            \printf('找到%d个key, keys: %s' . PHP_EOL, \count($keys), \json_encode(array_slice($keys, 0, 10, true), \JSON_PRETTY_PRINT));
////            $keyPrefix = $specialKey . ':';
////
////            $r->multi(Redis::PIPELINE);
////            foreach ($keys as $key => $val) {
////                \ctype_digit($key) && $r->setex($keyPrefix . $key, 86400 * 0.6, $val);
////            }
////            $ret = $r->exec();
//
////            $data = [];
////            foreach ($keys as $key => $val) {
////                $data[$keyPrefix . $key] = $val;
////            }
////            $ret = $r->mset($data);
////            echo  'success processed:' , \count(\array_filter($ret)), PHP_EOL;
////            exit;
//        });


//       ->handleByClosure(function(array $keys) use($r, $dst) {
//           printf('找到%d个key, keys: %s' . PHP_EOL, count($keys), implode(', ', array_slice($keys, 0, 5)));
//            /**
//             * @var \Redis $r
//             * @var \Redis $pipe
//             * @var \Redis $dst
//             */
//           $pipe = $r->pipeline();
//           foreach ($keys as $key) {
//               $pipe->ttl($key);
//           }
//           if ($result = $pipe->exec()) {
//               $result = \array_combine($keys, $result);
//    //           $result = \array_combine($keys, array_map('json_encode', $result));
//           }
//    //       $result = array_filter($result, function($ttl){
//    //            return $ttl === -1;
//    //       });
//    //       $pipe = $r->pipeline();
//    //       foreach ($result as $key => $val) {
//    //           $key = \str_replace('wduser:login:session_', 'wduser:login:_session_', $key);
//    //           $pipe->setex($key, 86400 * 5, $val);
//    //       }
//    //       $pipe->exec();
//    //       exit;
//            $total = \count($result);
//            $successTotal = 0;
//            foreach ($result as $key => $ttl) {
//                $raw = $r->dump($key);
//                $dst->del($key);
//                $dst->restore($key, $ttl < 0 ? 0 : $ttl, $raw) && $successTotal++;
//            }
//            echo '成功:', $successTotal, ' ,总数:', $total, PHP_EOL;
//            exit;
//       });

//    ->handleByClosure(function($keys) use($r, $dst){
//        printf('找到%d个key, keys: %s' . PHP_EOL, count($keys), implode(', ', array_slice($keys, 0, 5)));
//
//        /**
//         * @var \Redis $r
//         * @var \Redis $pipe
//         * @var \Redis $dst
//         */
//        $pipe = $r->multi(Redis::PIPELINE);
////         $filteredKeys = $keys;
//        foreach ($keys as $key) {
//           $pipe->ttl($key);
//        }
//        if ($result = $pipe->exec()) {
//           $result = \array_combine($keys, $result);
//        }
//        $result = array_filter($result, function($ttl){
////            return $ttl === -1 || $ttl > 3600;
//            return $ttl === -1;
//        });
//        if (count($result) === 0) {
//            return;
//        }
//        $filteredKeys = \array_keys($result);
////        $pipe = $r->multi(Redis::PIPELINE);
////
////        foreach ($filteredKeys as $filteredKey) {
////            $pipe->expire($key, 86400 * 2);
////        }
////        $ret = $r->exec();
////        \var_dump($filteredKeys);
////        $ret = count($filteredKeys) ? $this->redis->unlink(...$filteredKeys) : 0;
//        printf('找到%d个key, 处理成功%d, keys: %s' . PHP_EOL, count($filteredKeys), $ret, implode(', ', $filteredKeys));
//        exit;
//    });
        ->analysisSize(1500, 200);
//    ->analysisTtl(1500, 200);
//    ->ttlFilter()
//     ->batchCleanByTtl(function(array $data) use($r){
////         printf('找到%d个key' . PHP_EOL, count($data));
//         $filteredData = array_filter($data, function($ttl){
//            return $ttl > 86400 * 30;
//         });
//         $filteredKeys = \array_keys($filteredData);
//         usleep(1000);
//         $ret = count($filteredKeys) ? $r->del(...$filteredKeys) : 0;
//         $ret && printf('共有%d个key, 找到%d个匹配的key, 删除成功%d, keys: %s' . PHP_EOL, count($data), count($filteredKeys), $ret, implode(', ', array_slice($filteredKeys, 0, 20)));
//         // var_dump($filteredData);
////         exit;
//     });
    // ->analysisTtl();
//     ->analysisBigKeys();

} catch (Exception | Error $e) {
    echo $e->getMessage(), PHP_EOL;
}
exit;

