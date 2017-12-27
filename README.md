# Hipe Property Engine

A ***Wordpress plugin*** for ***Real Estate*** thats able to connect any wordpress Website with the [Milenio Plus](http://milenioplus.com) CRM, a powerfull and online Real Estate CRM.


## Installation

* Download plugin from [Direct link](https://github.com/kikoseijo/ideas-property-engine/blob/master/zip/ideas-property-engine.zip?raw=true).
* Install plugin and activate it.

## Configuration

First lets create a new page in worpdress to show the plugin, the Property Search Engine, add the following shortcode to the page content editor:

```
[mpvc-listings]
```

Create the property details page with the following shortcode:

```
[mpvc-detail]
```

### Configure the plugin
Now its time to configure the plugin with your preferences, go back to the wordpress administration area, if plugin its correctly activated
you will find a new menu on the left menu ***"Hipe Agent"***, this is where most of plugin configuration can be done, you should navigate
trought the diferent configuration screens and setup your own.

### Configure API credentials
The settings are located in the "***API Credentials***" section, this is an important step and should be done right using the information provided
by Milenio Plus, this are your personal credentials, otherwise plugin will not work on your own website.

## Troubleshooting
Contact [DiseñoIdeas.com](http://disenoideas.com) for any enquires about getting help configuring the plugin or any extra customization you need to have it done,
we will be pleased to help with any problems or enhancements you would like to have done.


### Multi-language support
Its posible to set diferent detail page for each language, for this you can include
a special tag in the shortcode, will be diferent deppending on your Wordpress configuration and
the translation plugins you are using.

```
[mpvc-listings detail_page="/my-translated-details-page/?lang=en"]
```

## Screenshots

Here you can see some screenshots of the plugin views and admin settings.

### Front page

#### Customers search engine

![Property search engine](/img/shoots/property-search-engine.jpg?raw=true "Property search engine on the front view")

#### Property results view examples

![Property results layout 1](/img/shoots/property-list-view-1.jpg?raw=true "Property list view 1 in results")
![Property results layout 2](/img/shoots/property-list-view-2.jpg?raw=true "Property list view 2 in results")
![Property results layout 3](/img/shoots/property-list-view-3.jpg?raw=true "Property list view 3 in results")

#### Property detail view

![Property detail view](/img/shoots/property-detail-view.jpg?raw=true "Property detail view")

### Wordpress options

This are views you can find inside Wordpress administration control panel, they provide additional options for visualization and styling.

#### Property search for admins

![Admin property search](/img/shoots/admin-property-search.jpg?raw=true "Property search engine for the front")

#### Admin options for search & results
![Configure search](/img/shoots/admin-configure-search.jpg?raw=true "Configure search and results page")

#### Property search for admins
![Configure api](/img/shoots/admin-api-settings.jpg?raw=true "Admin options for api credentials settings")

## Credits

Special thanks to supporters and clients that provide me with enough time to work on contributing to develop this packages for the WWW.

[DevOps](https://sunnyface.com "Programador ios málaga Marbella") Web development  
[AppDev](https://gestorapp.com "Gestor de aplicaciones moviles en málaga, mijas, marbella") Mobile aplications  
[SocialApp](https://sosvecinos.com "Plataforma móvil para la gestion de comunidades") Residents mobile application  
[KikoSeijo.com](https://kikoseijo.com "Programador freelance movil y Laravel") Freelance senior programmer

---
<div dir=rtl markdown=1>Created by <b>Kiko Seijo</b></div>
