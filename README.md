# Mjml Template Bundle
Create and send emails with mjml templates in Pimcore!

## Installation
```bash
composer require pimcorecasts/mjml-template-bundle
```

## Activate in bundles.php
```php
return [
    // ...
    MjmlTemplateBundle\MjmlTemplateBundle::class => ['all' => true],
    // ...
];
```

## Node js Setup
For this version it is necessary to install the mjml package locally.
```bash
npm install mjml
```

## Docker Setup
Use the following in your docker-compose.yml:
```yaml
services:
    mjml:
        image: adrianrudnik/mjml-server
        ports:
            - 8300:80
        environment:
            - CORS=*
            - MJML_KEEP_COMMENTS=true
            #- MJML_VALIDATION_LEVEL=strict
            - MJML_MINIFY=false
            - MJML_BEAUTIFY=true
```
### Override default node service
In your `config/services.yaml` add following:
```yaml
    Pimcorecasts\Bundle\MjmlTemplate\Services\DockerMjmlApi:
        arguments:
            - '1'
            - '2'
    mjml_renderer:
        class: Qferrer\Mjml\Renderer\ApiRenderer
        arguments:
            - '@Pimcorecasts\Bundle\MjmlTemplate\Services\DockerMjmlApi'
```

