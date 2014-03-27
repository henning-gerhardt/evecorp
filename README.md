# Eve Online Corporation Tool

Integration of EvE data through Eve API calls or data from other EvE third party developers developed / hosted sites.

## Requirements

* Typo3 version 6.1 
* some time as usual

## Using

* install as Typo3 extension
* create a system folder
* fill created folder with some data from [Eve-Central](http://eve-central.com/) (usually EvE Name and used id of Eve-Central)
* insert plugin on any site you want
* connect created system through behaviour tab inside plugin configuration

### PhealNG hints

* configure PhealNG existing and writable caching directory through backend module inside Extension Manager

## Background

Why not develop something in two things which makes fun? Typo3 extension development on one side and playing EvE on the other?

Started as basic example of Typo3 extension development on version 6.0 (how its works in general and what changed since version 4.2) and searching of current market data from Jita 4-4, the idea was born to merge this two things together. After first presentation inside my corporation some suggestions (f.e. showing / hiding prices based on corporation tax) were made and later implemented. Other suggestions came through development and using earlier versions like caching of market data to reduce calling third party sites.

## Copyright notice

* EvE and any IP of EvE are copyrighted by CCP hf. ( ©CCP hf. All rights reserved. Used with permission. )
* [PhealNG](https://github.com/3rdpartyeve/phealng) developed by Peter Petermann
* Evecorp Extension developed and licensed under GPL 3.0 or any later
