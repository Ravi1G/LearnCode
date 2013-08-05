LearnCode
=========

A learning platform for an introduction to programming


Idea
====

A platform-agnostic automated judge, but with a goal to support learning. The initial idea is of developing an Eclipse-plugin, so we can leverage a client-side debugging support and avoid artificial constraints put up competitive environments.


Implications
============

This can be used in the official course for "Introduction to Programming".


References
==========

[1] http://topcoder.com
[2] http://codeforces.com

Status
=======

- the normal spoj/codeforces style is working fine
- admin could add + edit the questions
- topcoder style still needs some work

Installation
=============

+ create a new database in mysql. you might give it any name.

+ update the database name, host, username and password of mysql in server_constraints.php

+ setup the database using the dodge.sql file in the repo. It will create all the tables necessary for operation

+ put all the code in var/www/<somefolder>. The folder in which you put the code + all the subfolders, need to have default root access (google it if you dont know how to use *chmod* and *chown* commands, otherwise all the read and write operations would fail.

+ It wont work on windows environment, as it uses gcc and g++ compilers installed on linux. Make sure on your linux machine, gcc and g++ are installed

