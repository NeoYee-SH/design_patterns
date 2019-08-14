## 设计模式相关概念
<a href=""></a>

    顺序编程
    面向过程编程
    团队速度
    模块化
    面向对象编程（OOP，对象）
    抽象类（abstract）
    接口（interface，instanceof）
    类型提示
    封装
    继承（浅继承，多重继承，trait）
    多态
    MVC
    统一建模语言（UML）
    
## 设计模式基本原则
<a href=""></a>

    单一职责原则（Single Responsibility Principle）
    里氏替换原则（Liskov Substitution Principle）
    依赖倒置原则（Dependence Inversion Principle）
    接口隔离原则（Interface Segregation Principle）
    迪米特法则（Law Of Demeter
    开闭原则（Open Close Principle）
    
    按接口而不是按实现编程
    类型提示用接口而不是具体类指定数据类型
    优先选择对象组合而不是类继承


## 选择设计模式

设计模式按照作用可以分为3大类：
    
    创建型
    结构型
    行为型

按范围划分可以分为2大类：
    
    类
    对象

1. 创建型设计模式（Creational Patterns）

    顾名思义，创建型模式就是用来创建对象的模式。更确切地讲，这些模式是对实例化过程的抽象。如果程序越来越依赖组合，就会减少对硬编码实例化的依赖，而更多地依赖于一组灵活的行为，这些行为可以组织到一个更为复杂的集合中。创建型模式提供了一些方法来封装系统使用的具体类的有关知识，还可以隐藏实例创建和组合的相关信息。

        单例（Singleton）
        简单工厂（Simple Factory）
        工厂方法（Factory Method）
        抽象工厂（Abstract Factory）
        生成器（Builder）
        原型（Prototype）
    
2. 结构型设计模式（Structural Patterns）

    这些模式所关心的是组合结构应当保证结构化。结构型类模式 (structural class patterns) 采用继承来组合接口或实现。结构型对象模式 (structural object patterns) 则描述了组合对象来建立新功能的方法。了解结构型模式对于理解和使用相互关联的类(作为设计模式中的参与者)很有帮助。

        适配器模式（Adapter）
        桥接模式（Bridge）
        组合模式（Composite）
        装饰器模式（Decorator）
        外观模式（Pacade）
        享元模式（Flyweight）
        代理模式（Proxy）
        
3. 行为型设计模式（Behavioral Patterns）

    到目前为止，绝大多数模式都是行为型对象。这些模式的核心是算法和对象之间职责的分配。Gamma等人指出，这些设计模式描述的不只是对象或类的模式，它们还描述了
    类和对象之间的通信模式。
    
        职责链模式（Chain of Responsibility）
        命令模式（Command）
        解释器模式（Interpreter）
        迭代器模式（Iterator）
        中介者模式（Mediator）
        备忘录模式（Memento）
        观察者模式（Observer）
        状态模式（State）
        策略模式（Strategy）
        模板方法模式（Template Method）
        访问者模式（Visitor）

4. 类设计模式
    
    在两类范围中，第一类范围是类(class) 。这些类模式的重点在于类及其子类之间的关系。在GoF的《设计模式》一书介绍的24个设计模式中，类范围中只包括4种模式。这一
    点并不奇怪，因为类模式中的关系是通过继承建立的，而且GoF更多地强调组合而不是继承。类模式是静态的，因此在编译时已经固定。

5. 对象设计模式

    尽管大多数设计模式都属于对象范围(objectscope)，不过与类范围中的那些模式一样，很多模式也会使用继承。对象设计模式与类模式的区别在于，对象模式强调的是可
    以在运行时改变的对象，因此这些模式更具动态性。
    