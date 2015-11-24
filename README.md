# hqimt-PHP-Project
一、医疗旅游项目基于zend framework
1）海外版和国内版后台的代码为backend目录，后台代码
2）海外版和国内版接口的代码为front目录，接口API代码
3）数据库暂不提供
4）所有代码的数据库配置信息均在application/configs/application.ini文件中
5）海外版和国内版代码需要分开部署
6）环境要求：mysql版本大于5.0;PHP版本大于5.3
7）models层 MOR为通过脚手架自动生成，区分Controller和models业务逻辑，M层中核心逻辑编写
8）Controller层根据业务通过save和fetchByName形式进行数据update和insert操作。

例子，请访问：
http://www.baiooy.com/ 后台代码  username：admin   passwd：123456
接口访问地址：http://interface.baiooy.com/banner/index  可不用带参数
