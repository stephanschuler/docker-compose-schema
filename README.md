Create docker-compose via PHP
=============================

Creating docker-compose yaml files is very frustrating to me because the environment
I'm at home lacks some support.

The language I am fluent in is PHP and there are plenty IDEs out there that understand
PHP very well.

This package aims for providing reasonably strong typed PHP classes that are just
JsonSerializable and create valid docker-compose.yaml files.


Current state of development
----------------------------

This package is not even close to be finished. I have some actual use cases to play
with and I'm trying to cover those af first. But I do know there are a lot of things
you can do with docker-compose that are not supported by this lib just because I
haven't used them and didn't come around to put them in.


Example
-------

This could be a small docker-compose file:

```
version: "3.8"
services:
  web:
    image: "httpd:2.4"
    ports:
      - "8080:80"
      - "4443:443"
    networks:
      - my-network
    environment:
      - SOME_ENV_VAR=fooo
    links:
      - redis
  redis:
    image: "redis:alpine"
    networks:
      - my-network
networks:
  my-network:
    ipam:
      config:
        -
          subnet: 172.198.100.0/24
```

This is how it would be created in PHP:
```
<?PHP

$composition = Composition::create()
    ->withVersion('3.8');

$network = $composition->network('my-network');
$network
    ->withIpam(
        Ipam::create()
            ->withSubnet('172.198.100.0/24')
    );


$web = $composition->service('web');
$web
    ->fromImage(Image::create('http', '2.4'))
    ->withPort(Port::create(80)
        ->redirectedTo(8080))
    ->withPort(Port::create(443)
        ->redirectedTo(4443))
    ->withNetwork($network)
    ->withEnvironment(EnvironmentVariable::named('SOME_ENV_VAR')
        ->withValue('fooo'));

$redis = $composition->service('redis');
$redis
    ->fromImage(Image::create('redis', 'alpine'))
    ->withNetwork($network);

$web->withLinkedService($redis);

echo json_encode($composition, JSON_PRETTY_PRINT);

```

But why?
--------

Obviously this way of doing things is a little bit more verbose.
But honestly: I think that's a good thing. It feels a bit more expressive.

But the main reason is being able to pass around variables hand having them
checked internally. Noticed the `web`  service which is linked to the `redis`
service somehwere at the bottom of the PHP code? Now my IDE makes sure I
spell everything correctly and I only link things together that are actually
already defined. Sure, I could have `docker-compose` tell me about that.
But I prefer being helped and supported as soon as possible.

I minor thing I discovered when typing this little example: Maybe creating
the web service as at first, defining the redis service afterwards and
finally being able to link both together is a smell of thinking about the
setup backwards.

And now think about loops and conditions and being able to create docker
compose definitions really dynamically.
