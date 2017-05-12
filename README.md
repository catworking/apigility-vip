# Apigility Vip 会员组件
本组件提供用户的会员身份管理，会员服务管理，会员服务合约管理等功能。

### 依赖组件
- [Apigility User](https://github.com/catworking/apigility-user) Vip组件属于User组件的功能扩展，所以必须依赖User组件
- [Apigility Order](https://github.com/catworking/apigility-order) Vip组件有会员购买的功能，会形成订单并需要支付，
  所以必须依赖Order组件的订单管理和支付功能

## 数据实体

### 会员身份 Status
身份是会员的一种类型，比如普通会员、白银会员、黄金会员、钻石会员，这些都是会员身份的例子。

### 会员服务 Service
会员服务在这里是一个虚拟商品，用于对会员身份进行标价。每一个服务都会关联一个身份，并且指定了
服务时长，价格。

### 会员合约 Contract
用户购买一个会员服务，实际上是与服务提供方签下了一个服务合约，合约指定了用户购买了什么服务，
以及购买的数量。

因为合约是需要支付费用的，所以合约还关联了一个订单（Apigility Order组件的Order实体）。