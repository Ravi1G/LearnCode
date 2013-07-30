<?php
/*execute program and write all output to $out
terminate program if it runs more than 3 seconds and return 0 else return 1*/

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
            //get the parent pid of the process we want to kill
            /*$ppid = $status[$process];
            
            //use ps to get all the children of this process, and kill them
            $pids = preg_split('/\s+/', `ps -o pid --no-heading --ppid $ppid`);
            foreach($pids as $pid) {
                if(is_numeric($pid)) {
                    echo "Killing $pid\n";
                    posix_kill($pid, 9); //9 is the SIGKILL signal
                }
                    //echo "terminated";
                    return 1;
                }*/
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
?>