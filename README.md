LogsServe
========
A viewer to nicely display log files.

1.Download
-----------

Open a command console, enter your project directory and execute the following command:
```
$ composer require tarnawski/logs-serve
```

2.Enable the Bundle
-------------------
Enable the bundle by adding it to the list of registered bundles in the app/AppKernel.php file of your project.

```
<?php
$bundles = array(
    new LogsServeBundle\LogsServeBundle(),
);
```

3.Register the Routes:
---------------------
```
LogsServeBundle:
    resource: "@LogsServeBundle/Resources/config/routing.yml"
    prefix:   /logs
```

4.Configure the Bundle:
------------------------
```
log_viewer:
    logs:
      dev:
        path: /var/logs/dev.log
        method: json
      test:
        path: /dev/shm/api-backend/logs/test.log
        method: string
    max_tail: 500
```


You can browse the whole logs at: http://your-app/logs/{name}
