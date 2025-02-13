<?php
// Lab1 task5
function randomCharacter() // нажаль також повертає рашкові букви
{
    $unicode_code = mt_rand(0x410, 0x42F);
    return mb_chr($unicode_code, 'UTF-8');
}

for ($i = 0; $i < 7; $i++) {
    $buf = randomCharacter();
    switch (mb_strtolower($buf, 'UTF-8')) { // рашкові букви не розглядаються
        case 'а': 
        case 'е': 
        case 'є':
        case 'и':
        case 'і':
        case 'ї':
        case 'о':
        case 'у':
        case 'ю':
        case 'я': {
            echo "Буква $buf є голосною<br>";
            break;
        }
        default: {
            echo "Буква $buf є приголосною<br>";
            break;
        }
    }
}