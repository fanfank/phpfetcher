<?php
class errcode {
    const ERR_SUCCESS = 0;
}
if (errcode::ERR_SUCCESS === 0) {
    echo "defined ERR_SUCCESS\n";
}
?>
