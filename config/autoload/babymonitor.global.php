<?php

return array(
  'cache' => array(
      'adapter' => array(
          'name' => 'redis',
          'options' => array(
              'server' => array(
                  'host' => 'localhost',
                  'port' => '6379',
              )
          )
      ),
      'plugins' => array(
          // Don't throw exceptions on cache errors
          'exception_handler' => array(
              'throw_exceptions' => false
          ),
          'serializer'
      )
  )
);