# 基于旷视九霄的人脸识别

1. 安装 : composer require finalsmile6868/kuangshi

2. Laravel添加以下类到config/app.php文件的providers数组中

   Finalsmile6868\Kuangshi\KuangshiServiceProvider::class

3. 生成数据库表

   php artisan migrate

4. 生成config/kuangshi.php配置文件

   php artisan vendor:publish

5. 在 config.kuangshi.php文件中，配置AppKey,SecretKey

   [获取AppKey,SecreKey](https://cloud9.megvii.com/system_manage/open_api)

6. 可在config.kuangshi.php文件的route数组中，配置路由前缀(prefix),默认ks

7. 目前支持员工列表同步，默认路径为  /ks/person，如果修改了路由前缀，则，路径为 /修改的路由前缀/person

   [字段含义见此处](https://cloud9.megvii.com/docs/web/part7/1.html#%E5%88%86%E9%A1%B5%E6%9F%A5%E8%AF%A2%E4%BA%BA%E5%91%98%E5%88%97%E8%A1%A8)

8. 旷视的事件回调，目前支持人员事件；默认回调路由 /ks/notify.

   在收到事件回调后，回写入kuangshi_event_record表，然后发出一个事件通知：Finalsmile6868\Kuangshi\Events\KuangshiEvent.php;
   要接收此事件，需要在app/Providers/EventServiceProvider.php指定要接收的时间，例如：
      ```php
'Finalsmile6868\Kuangshi\Events\KuangshiEvent'=>[
     'App\Listeners\KuangshiListener',//改为接收事件的Listener
 ],
   ```
	可以参考Finalsmile6868\Kuangshi\Linsteners\KuangshiLinstener.php
9. 

   

   

   

   

   

   

   

   

   

   

   

   