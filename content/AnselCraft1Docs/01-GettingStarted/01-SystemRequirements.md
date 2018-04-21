{
    "title": "System Requirements"
}

### General Requirements

- Craft CMS 2.6 or greater
- PHP 5.3.0 or newer compiled with GD (or GD 2) library
    - ImageMagick is also supported if installed
- MySQL 5.1.0 or newer
- At least 128 megabytes of memory allocated and available to PHP
    - 512 megabytes is recommended (and more if you can spare it). Manipulating images can take a lot of memory. And particularly, the larger image, the more memory it will take.
    
### Control panel interface and entry field type use requirements

- Internet Explorer 10 or greater
- Chrome (tested on version 55)
- Firefox (tested on version 50)
- Safari (Mac) (tested on version 10)

### Image optimization requirements

Ansel will also utilize various image optimization libraries if they are installed on the server and your PHP version is high enough.

- PHP 5.5 or greater
- `jpegoptim` for jpeg optimization
- `gifsicle` for gif optimization
- `optipng` for PNG optimization
