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

## Usage

Now you can create a layout like `layout/email.html.twig`
```html
{% mjml %}

    <mjml>
        <mj-body width="580px">
            <mj-wrapper background-color="#fff" border="1px solid #e7e7e7" border-top="0" border-bottom="0" padding="0">
                {{ block('content') }}
            </mj-wrapper>
        </mj-body>
    </mjml>

{% endmjml %}
```

Add a `email/content.html.twig`:
```html
{% extends 'email/layout.html.twig' %}

{% block content %}
    <mj-text mj-class="btn-primary">
        Your Pimcore email template
    </mj-text>
{% endblock %}
```