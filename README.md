# piwigo-paver-panorama
Piwigo plugin to show panoramas based on the paver js library.

There are two plugins available for Piwigo that show full 360-180 panoramas:

* PhotoSphere: http://piwigo.org/ext/extension_view.php?eid=794
* Panoramas: http://de.piwigo.org/ext/extension_view.php?eid=207

They both a) seem not to be maintained anymore and b) only support "full" 180/360 degree panoramas. In 2017 things have progressed a bit an e.g. Facebook can also show non-full panoramas from Google in a similar way (easy scrolling in all directions, ...).

So this is an attempt to create a new plugin based on the Paver js library (https://github.com/terrymun/paver). As a basis the PhotoSphere plugin will be used since I like the idea of storing in the database whether a picture should be shown as panorama. That allows to make the choice based on various aspects and not only the exif metadata that indicates a google panorama. E.g. my definition of a panorma is everthing with a width/height ratio larger than 3.5.

##Roadmap

- Initial creation of working plugin using manual selection of pictures
- Add (optionally) algorithms to determine panoramas - e.g. google exif metadata, width/height ratio, ??? Could be used during picture upload to fill the flag initially
- Maybe: Merge with existing PhotoSphere plugin to give users the choice of js library they want to use
