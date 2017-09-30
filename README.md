# EVE Online Corporation Tool

Integration of EVE data through EVE API calls or data from other EVE third party developers developed / hosted sites.

## Requirements

* TYPO3 version 7.6
* some time as usual

## Using

* install as TYPO3 extension
* create a system folder
* fill created folder with some data from [Eve-Central](http://eve-central.com/) (usually EVE Name and used id of Eve-Central)
* insert plugin on any site you want
* connect created system through behaviour tab inside plugin configuration

### Install hints

* static dump of region and solar system map data is included in ext_tables_static+adt.sql which must included after extension installation

### PhealNG hints

* configure PhealNG existing and writable caching directory through backend module inside Extension Manager

## Background

Why not develop something in two things which makes fun? TYPO3 extension development on one side and playing EVE on the other?

Started as basic example of TYPO3 extension development on version 6.0 (how its works in general and what changed since version 4.2) and searching of current market data from Jita 4-4, the idea was born to merge this two things together. After first presentation inside my corporation some suggestions (f.e. showing / hiding prices based on corporation tax) were made and later implemented. Other suggestions came through development and using earlier versions like caching of market data to reduce calling third party sites.

## Code analysis

Using automatic code analysis tools is a good practice and used in this project 

[![Codacy Badge](https://api.codacy.com/project/badge/grade/1221c637986c4e939f0a927aeafd46a6)](https://www.codacy.com/app/henning-gerhardt/evecorp)

## Copyright notice

* EVE Online and any IP of EVE Online are copyrighted by CCP hf. ( ©CCP hf. All rights reserved. Used with permission. )
* [PhealNG](https://github.com/3rdpartyeve/phealng) developed by Peter Petermann
* Evecorp Extension developed and licensed under GPL 3.0 or any later
