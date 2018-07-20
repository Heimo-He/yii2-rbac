# yii2-rbac

> Yii2 rbac 精简版(无对外接口) **仅供无需rbac接口的api应用使用**
> 根据[yii2-rest-rbac（https://github.com/heimohoney/yii2-rest-rbac）](https://github.com/windhoney/yii2-rest-rbac)修改
> 

* **安装:**

```
composer require Heimo-He/yii2-rbac
```

### **使用**

* **配置权限**
```php
    'components' => [
        'authManager' => [
            'class' => 'heimo\rbac\components\DbManager', //配置文件
        ],
    ],

    'as access' => [
        'class' => 'heimo\rbac\components\AccessControl',
        'allowActions' => [//允许访问的节点，可自行添加
            'login/*',
            'logout/*',
            'callback/*',
        ]
    ],
```


* **创建所需要的表**

1.菜单表menu

```
yii migrate --migrationPath=@vendor/Heimo-He/yii2-rbac/migrations
```

2.rbac相关权限表
```
yii migrate --migrationPath=@yii/rbac/migrations/
```
