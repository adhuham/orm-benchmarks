# ORM Benchmarks
Benchmarks between Eloquent ORM, Laravel's Query Builder, Hydro and PDO.

### Run
1. Clone the repo
2. Run `php RunTests.php` in the root of cloned directory

### Result 
```
|--------------------------------------------------|
| Insert (Lower is better) 
|--------------------------------------------------|

t=33ms     Eloquent ORM                                      
==========================================

t=14ms     Laravel Query Builder                             
==================

t=10ms     Hydro (using Models)                              
============

t=8ms      Hydro (Normal)                                    
==========

t=8ms      Hydro (using Raw queries)                         
==========

t=4ms      RawPdo                                            
=====



|--------------------------------------------------|
| Select (Lower is better) 
|--------------------------------------------------|

t=35ms     Eloquent ORM                                      
============================

t=26ms     Laravel Query Builder                             
====================

t=30ms     Hydro (using Models)                              
========================

t=13ms     Hydro (Normal)                                    
==========

t=12ms     Hydro (using Raw queries)                         
=========

t=9ms      RawPdo                                            
=======



|--------------------------------------------------|
| Where (Lower is better) 
|--------------------------------------------------|

t=104ms    Eloquent ORM                                      
=======================

t=92ms     Laravel Query Builder                             
====================

t=86ms     Hydro (using Models)                              
===================

t=61ms     Hydro (Normal)                                    
=============

t=55ms     Hydro (using Raw queries)                         
============

t=49ms     RawPdo                                            
==========



|--------------------------------------------------|
| Hydrate (Lower is better) 
|--------------------------------------------------|

t=88ms     Eloquent ORM                                      
=====================

t=78ms     Laravel Query Builder                             
===================

t=76ms     Hydro (using Models)                              
==================

t=60ms     Hydro (Normal)                                    
==============

t=56ms     Hydro (using Raw queries)                         
=============

t=50ms     RawPdo                                            
============



|--------------------------------------------------|
| Join (Lower is better) 
|--------------------------------------------------|

t=133ms    Eloquent ORM                                      
======================================

t=65ms     Laravel Query Builder                             
===================

t=28ms     Hydro (using Models)                              
========

t=44ms     Hydro (Normal)                                    
============

t=41ms     Hydro (using Raw queries)                         
===========

t=31ms     RawPdo                                            
=========



|--------------------------------------------------|
| Memory (Lower is better) 
|--------------------------------------------------|

m=7,542,920 Eloquent ORM                                      
===========================================================================

m=1,455,736 Laravel Query Builder                             
==============

m=318,128  Hydro (using Models)                              
===

m=278,480  Hydro (Normal)                                    
==

m=278,584  Hydro (using Raw queries)                         
==

m=138,688  RawPdo                                            
=
```
