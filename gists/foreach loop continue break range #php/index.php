<?php
for($i = 0; $i <= 10; $i++)
{
    if( $i === 4 )
    {
        continue;    
    }
    if( $i === 6 )
    {
        break;    
    }
    echo $i;
}

foreach( range(0,10) as $i )
{
    if( $i === 4 )
    {
        continue;    
    }
    if( $i === 6 )
    {
        break;    
    }
    echo $i;
}