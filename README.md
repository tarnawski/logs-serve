LogsServe
========
Tool to serve logs files in JSON format.

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
    prefix:   /logs-serve
```

4.Configure the Bundle:
------------------------
```
logs_serve:
    secret_key: 159951
    logs:
      mysql:
        path: /var/log/mysql/error.log
        lines: 100
      apache:
        path: /var/log/apache2/error.log
        lines: 10
```

Without Symfony framework
-------------------------
```
<?php

$parameters = [
    'mysql' => [
        'path' => '/var/log/mysql/error.log',
        'lines' => 100
    ],
    'apache' => [
        'path' => '/var/log/apache2/error.log',
        'lines' => 10
    ]
];

$fileReader = new \LogsServeBundle\Reader\FileReader();

foreach ($parameters as $name => $parameter) {
    $data = $fileReader->read($parameter['path'], $parameter['lines']);

    $logs[] = [
        'name' => $name,
        'logs' => isset($data) ? $data : []
    ];
}

$response = isset($logs) ? $logs : [];

$jsonResponse = json_encode($response);
```
