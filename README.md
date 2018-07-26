## mmxs/swagger-bundle

### usage


```php
    composer require mmxs/swagger-bundle
    
    touch config/packages/dev/swagger.yaml
    
```

```yaml
swagger:
    groups:
      main:
        paths:
        - '%kernel.project_dir%/src/Resources/config/swagger/swagger.yaml'
        - '%kernel.project_dir%/src/Resources/config/swagger/paths/user.yaml'
```
