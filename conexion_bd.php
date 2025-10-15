<?php

$conex = mysqli_connect('localhost', 'root', '') or die(mysqli_errno($conex));
mysqli_select_db($conex, "trabajosw");

