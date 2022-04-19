<?php

class S3Util {
    protected $verbose;
    protected $syslog;
    protected $client;

    public function __construct($client, $verbose = false, $syslog = null) {
        $this->client = $client;
        $this->verbose = $verbose;
        $this->syslog = $syslog;
	}

    public function createSignedUrl($bucket, $key, $duration, $options = []) {

        $options['Bucket']  = $bucket;
        $options['Key']     = $key;

        $request = $this->client->createPresignedRequest(
            $this->client->getCommand('GetObject', $options),
            $duration);

	    // Get the actual presigned-url
        return (string)$request->getUri();
    }

    public function copyFileToS3($bucket, $rfile, $sfile) {
        $st = stat($sfile);

        try {
            $result = $this->client->headObject(
                array(
                    'Bucket'    => $bucket,
                    'Key'       => $rfile
                )
            );
        } catch (Exception $e) {
            $result = false;
        }

        if ($result) {
            $rmsize = $result['ContentLength'];
            $rmtime = @$result['Metadata']['originalmodificationdate'];
        } else {
            $rmsize = 0;
            $rmtime = 0;
        }

        if ($result && $rmsize == $st['size'] && $rmtime == $st['mtime'])
            return true;

        $nretries = 3;
        $ok = false;
        do {
            $retry = false;
            try {
                $result = $this->client->putObject(
                        array(
                            'Bucket'     => $bucket,
                            'Key'        => $rfile,
                            'SourceFile' => $sfile,
                            'Metadata'   => array(
                                'originalmodificationdate' => $st['mtime']
                        )
                    )
                );
                if ($this->verbose && $this->syslog)
                    $this->syslog->log(LOG_INFO, "copy file to $bucket: $rfile, $sfile");
                $ok = true;
            } catch (Exception $e) {
                if ($this->syslog)
                    $this->syslog->log(LOG_ERR, 'Caught exception [' . get_class($e) . ']: ' . $e->getMessage());
            }
        } while ($retry && (--$nretries > 0));

        return $ok;
    }
}

