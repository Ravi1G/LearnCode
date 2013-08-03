<?php
/*execute program and write all output to $out
terminate program if it runs more than 3 seconds and return 0 else return 1*/
error_reporting(E_ALL);
        ini_set('display_errors'.'1');
declare (ticks = 1);
   /* pcntl_signal(NZEC,  "sig_handler");
    pcntl_signal(SIGFPE, "sig_handler");
    pcntl_signal(SIGSEGV,  "sig_handler");
    pcntl_signal(SIGABRT,  "sig_handler");*/
  function sig_handler($sig) {
        echo "fadsf";
        # one branch for signal...

}
function execute($cmd, $stdin=null, &$stdout, &$stderr, $timeout=false)
{
  
    $pipes = array();
    $process = proc_open(
        $cmd,
        array(array('pipe','r'),array('pipe','w'),array('pipe','w')),
        $pipes
    );
    $stats = proc_get_status($process);
    $start = time();
    $stdout = '';
    $stderr = '';

    if(is_resource($process))
    {
        stream_set_blocking($pipes[0], 0);
        stream_set_blocking($pipes[1], 0);
        stream_set_blocking($pipes[2], 0);
        fwrite($pipes[0], $stdin);
        fclose($pipes[0]);
    }

    while(is_resource($process))
    {
        //echo ".";
        $stdout .= stream_get_contents($pipes[1]);
        $stderr .= stream_get_contents($pipes[2]);

        if($timeout !== false && time() - $start > $timeout)
        {
            fclose($pipes[1]); //stdout
            fclose($pipes[2]); //stderr
            posix_kill($stats['pid']+1,9);
            return 0;
        }   

        $status = proc_get_status($process);
        if(!$status['running'])
        {
            //echo "here";
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
            
            return 1;
        }

        usleep(100000);
    }
    echo "here";
    return 1;
}
function string_to_url($string)
{
    $j=0;
    while($j<strlen($string))
    {
        if($string[$j] == " ")
            $string[$j] = "+";
        $j++;
    }
    return $string;
}
function url_to_string($string)
{
    $j = 0;
    while($j<strlen($string))
    {
        if($string[$j] == "+")
            $string[$j] = " ";
        $j++;
    }
    return $string;
}
function string_to_cmd($string)
{
    $j = 0;
    $ret = "";
    while($j<strlen($string))
    {
        if($string[$j] == " ")
            $ret = $ret."\ ";
        else
            $ret = $ret.$string[$j];
        $j++;
    }
    return $ret;
}

function substring($main, $sh)
{
    $j = 0;
    while($j<strlen($main))
    {
        if($main[$j] == $sh[0])
        {
            if(substr($main,$j,strlen($sh)))
                return 1;
        }
        $j++;
    }
    return 0;
}

?>