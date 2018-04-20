{
    "title": "System Requirements"
}

### General requirements

- Craft CMS 3 or greater
- PHP 7.0 or newer compiled with GD (or GD 2 library)
    - ImageMagick is also supported if installed
- MySQL 5.5+ (with InnoDB) or PostgreSQL 9.5+
- At least 256 megabytes of memory allocated and available to PHP
    - 512 megabytes is recommended (and more if you can spare it). Manipulating images can take a lot of memory. And particularly, the larger image, the more memory it will take.
    
### Control panel interface and entry field type use requirements

- Edge 41 or greater
- Internet Explorer 11 or greater
- Chrome (tested on version 65)
- Firefox (tested on version 59)
- Safari (Mac) (tested on version 11)

### Image optimization requirements

Ansel will also utilize various image optimization libraries if they are installed on the server and your PHP version is high enough.

- PHP 5.5 or greater
- `jpegoptim` for jpeg optimization
- `gifsicle` for gif optimization
- `optipng` for PNG optimization
