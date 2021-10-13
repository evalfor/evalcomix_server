<?php
session_start();
unset($_SESSION['idsession']);
session_destroy();