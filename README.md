# StiwlPageBundle

Some times we have to make a web page faster, with the essential thinks web marketing, the solution is StiwlPageBundle.

Is a Bundle to create a completly Page Management, it is efficient to implement and ia a simple form to build fully manageable Website in few minutes.

Is a best choice for building a robust and powerful base for projects web pages or web systems.

### Features

* Menu - Page - News - Contact - Products contents.
* This bundle provides an Admin bundle and Doctrine2 ORM Admin bundle managements of Entities: User, Page, Menu, HeaderImage, Meda, News, Product and Category.
* Each Entities with languages and correctly associations.
* All Contents Management is provides from SonataAdminBundle.
* In Contact page the customer information, the form and google maps ubication is integrated.
* User Management provides by FOSUSerBundle.
* Integrates a google maps bundle by IvoryGoogleMapBundle.
* Integrates a paginator provides by KnpMenuPaginator Bundle.
* Integrates a text editor provides by CKEditorBundle.

The demo website can be found in http://www.constructoraivisal.com/ 


**Warning**: The bundle has been split in 13 composer requires:

* [SonataAdminBundle](https://github.com/sonata-project/SonataAdminBundle)
: the current one, contains the Admin bundle generator.
* [SonataBlockBundle](https://github.com/sonata-project/SonataBlockBundle)
: the current one, contains the Block bundle to sonata admin.
* [SonataIntlBundle](https://github.com/sonata-project/SonataIntlBundle)
: the current one, contains the Internalization bundle to sonata admin.
* [SonataDoctrineORMAdminBundle](https://github.com/sonata-project/SonataDoctrineORMAdminBundle) 
: Integrates the admin bundle into with the Doctrine ORM project.
* [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle) 
: Integrates the knp menu bundle.
* [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) 
: Integrates the knp paginator bundle.
* [SonataMediaBundle](https://github.com/sonata-project/SonataMediaBundle) 
: the current one, contains the Media bundle to sonata admin.
* [SonataNotificationBundle](https://github.com/sonata-project/SonataNotificationBundle) 
: the current one, contains the Notification bundle to sonata admin.
* [StofDoctrineExtensionsBundle] (https://github.com/stof/StofDoctrineExtensionsBundle)
: Integrates doctrine2 extension.
* [IvoryGoogleMapBundle] (https://github.com/egeloen/IvoryGoogleMapBundle)
: Integrates the google maps libraries.
* [IvoryCKEditorBundle](https://github.com/egeloen/IvoryCKEditorBundle) 
: Integrates the powerfull editor CKeditor.
* [FOSUserBundle] (https://github.com/FriendsOfSymfony/FOSUserBundle)
: Integrates the FOS user Bundle to manage the users in the system.

## Installation:

### Installation via composer. (http://getcomposer.org/)
```json
{
  "require": {
    "stiwl/page-bundle": "dev-master",
    "sonata-project/admin-bundle": "dev-master",
    "sonata-project/block-bundle": "dev-master",
    "sonata-project/intl-bundle": "dev-master",
    "sonata-project/media-bundle": "dev-master",
    "sonata-project/notification-bundle": "dev-master",
    "sonata-project/core-bundle": "dev-master",
    "sonata-project/doctrine-orm-admin-bundle": "dev-master",
    "knplabs/knp-menu-bundle": "1.1.x-dev",
    "knplabs/knp-paginator-bundle": "dev-master",
    "stof/doctrine-extensions-bundle": "dev-master",
    "egeloen/google-map-bundle": "dev-master",
    "egeloen/google-map": "*@dev",
    "egeloen/ckeditor-bundle": "2.*",
    "willdurand/geocoder": "*",
    "friendsofsymfony/user-bundle": "*"
  },
}
```

## How to use
### Add in appKernel.php: 

```php
<?php
// app/appKernel.php
public function registerBundles() {
    return array(
        new Knp\Bundle\MenuBundle\KnpMenuBundle(),
        new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        new Sonata\BlockBundle\SonataBlockBundle(),
        new Sonata\CoreBundle\SonataCoreBundle(),
        new Sonata\AdminBundle\SonataAdminBundle(),
        new Sonata\IntlBundle\SonataIntlBundle(),
        new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
        new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
        new Sonata\MediaBundle\SonataMediaBundle(),
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
        new Ivory\GoogleMapBundle\IvoryGoogleMapBundle(),
        new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
        new FOS\UserBundle\FOSUserBundle(),
        new Stiwl\PageBundle\StiwlPageBundle(),
        new Stiwl\PageBundle\Third\SonataAdminBundle\StiwlPageThirdSonataAdminBundle(),
        new Stiwl\PageBundle\Third\FOSUserBundle\StiwlPageThirdFOSUserBundle()
    );
}
```

### Add in your config
```yaml
# app/config/config.yml
imports:
    - { resource: '@StiwlPageBundle/Resources/config/config.yml' }
```    

### Add in your autoload.php to enable the Application Sonata Media Bundle
 You need to generate the correct entities for the media:
 php app/console sonata:easy-extends:generate SonataMediaBundle.
 Then create the directory web/uploads/media
 
 I suggest read all the documentation (http://sonata-project.org/bundles/media/master/doc/reference/installation.html#id1)

```php
<?php
// app/autoload.php
//custom for Application
$loader->add("Application", __DIR__);
```

### Then in your appKernel.php register the twoo bundles left
```php
<?php 
// app/appKernel.php
public function registerBundles() {
    return array(
        new Stiwl\PageBundle\Third\SonataMediaBundle\StiwlPageThirdSonataMediaBundle(),
        new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),
    );
}
?>
```

### Add in your routing

```yaml
# app/config/routing.yml
stiwl_pageB_third_sonata_admin:
    resource: "@StiwlPageThirdSonataAdminBundle/Resources/config/routing.yml"
    prefix: /admin
    
stiwl_pageB_third_media_admin:
    resource: "@StiwlPageThirdSonataMediaBundle/Resources/config/routing.yml"
    prefix: /media    
    
stiwl_pageB_third_fos_user:
    resource: "@StiwlPageThirdFOSUserBundle/Resources/config/routing.yml"
    prefix:   /      
    
stiwl_pageB_set_locale:
    path: /set-locale/{route}/{routeParams}
    defaults: { _controller: StiwlPageBundle:Page:setLocale, routeParams: null }
    
stiwl_pageB_page:
    path:  /page/{menuId}/{slug}
    defaults: { _controller: StiwlPageBundle:Page:page }

_stiwl_pageB:
    resource: .
    type: stiwl_page
    prefix: /      

stiwl_pageB_index:
    path: /
    defaults: {_controller: StiwlPageBundle:Page:index }
```

### Configure your security for FOSUserBundle security:

 I suggest read all the documentation (https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md#step-4-configure-your-applications-securityyml)

```yaml
# app/config/security.yml
security:
    firewalls:
        secured_area:
            pattern: ^/*
            anonymous: ~
            form_login:
                provider: fos_userbundle
                csrf_provider: form.csrf_provider
                login_path: fos_user_security_login
                check_path: fos_user_security_check
                default_target_path: fos_user_security_login
            logout:
                path: fos_user_security_logout
                target: fos_user_security_login
            remember_me:
                key:      "%secret%"
                lifetime: 31536000 # 365 days in seconds
                path:     /
                domain:   ~ # Defaults to the current domain from $_SERVER

    role_hierarchy:
        ROLE_ADMIN:  ['ROLE_USER']
        ROLE_SUPER_ADMIN: ['ROLE_ADMIN']

## add /(en|es) of some languages if you enabled the {_locale} in your app/config/routing.yml
    access_control:
        - { path: ^/(en|es)/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/(en|es)/register, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/(en|es)/resetting, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/(en|es)/admin/, role: ROLE_ADMIN }
# If not enabled {_locale} in your app/config/routing.yml        
#        - { path: '^/backend', roles: ['ROLE_ADMIN'] }
#        - { path: '^/secured', roles: ['ROLE_USER'] }
#        - { path: '^/guest/user', roles: ['ROLE_USER', 'IS_AUTHENTICATED', 'ROLE_ADMIN', 'ROLE_TEACHER'] }
        
    providers:
        fos_userbundle:
            id: fos_user.user_provider.username
          
    encoders:
        FOS\UserBundle\Model\UserInterface: { algorithm: sha512, iterations: 10 }

```    
    
## Configuration:

```yaml
# app/config/config.yml
stiwl_page:
    developer: STIWL
    website: http://www.stiwl.net/
    enterprise:
        name: Pharmacy S.A.C
        short_name: pharmacy
        business: Pharmaceutical products
        slogan: Quality and reliability
        money: $
        email: luis.sanchez.saldana@gmail.com
        address: Av. xxx #xxx
        phones: 
            ## add what you want, defaults are movil and office
            movil: { value: '#########' }
            office: { value: '######' }
        google_map:
            latitude: -12.09223
            longitude: -77.00050
            width: 300px
            height: 300px
    pages:
        news: 
            enabled: true
            #you can config the position last or first too
            position: 0
        products:
            enabled: true
            position: 1
        contact_us:
            enabled: true
            position: 2
        fos_user: 
            login:
                visible: false
                position: ~
            register:
                enabled: false
                position: ~
```
## Finally execute command to generate database and create schema from doctrine

* php app/console doctrine:database:create

* php app/console doctrine:schema:create

## Visit my Website and my Facebook page

* [STIWL](http:www.stiwl.com)
* [Facebook](http:www.facebook.com/stiwl)
