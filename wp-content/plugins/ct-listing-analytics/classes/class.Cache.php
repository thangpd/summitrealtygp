<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class ct_la_Cache
{

    var $useCache = true;
    
    function __construct()
    {
        if ( ! file_exists( dirname(__DIR__)."/tmp" ) ) {
            mkdir( dirname(__DIR__)."/tmp", 0755 );
        }    
    }


    private function generateKey( $keyParts )
    {

        $key = md5( serialize( $keyParts ) );

        return $key;
    }


    function getCache( $keyParts )
    {

        if ( $this->useCache === false ) {
            return false;
        }
        
        $key = $this->generateKey( $keyParts );

        if ( file_exists( dirname( __DIR__ )."/tmp/".$key ) ) {

            $read = file_get_contents( dirname( __DIR__ )."/tmp/".$key );

            $read = json_decode( $read, true );

            if( ( time() - filemtime( dirname( __DIR__ )."/tmp/".$key ) ) > intVal( $read["ttl"] ) ) {
                $this->deleteCache( $key );
            } else {     
                return $read["value"];
            }
        }

        return false;
    
    }

    function setCache( $keyParts, $value, $ttl )
    {

        $key = $this->generateKey( $keyParts );

        $write = [
            "ttl"   => $ttl,
            "value" => $value
        ];

        file_put_contents( dirname( __DIR__ )."/tmp/".$key, json_encode( $write ) );
        
        
        $this->deleteStaleTempFiles( );


    }

    function deleteCache( $key )
    {

        if ( file_exists( dirname( __DIR__ )."/tmp/".$key ) ) {
            unlink( dirname( __DIR__ )."/tmp/".$key );
        }

    }


    function clear()
    {
       
        $path = dirname( __DIR__ )."/tmp/";

		if( file_exists( $path ) ) {
			$dh = opendir($path);
	
	        	while ( ( $file = readdir( $dh ) ) !== false ) {
                    
                    if( $file != '.' && $file != '..' ) {

                        unlink( $path."/".$file );
                        
	        		}
	        	}
	        
			closedir($dh);
        } 
        
    }

    private function deleteStaleTempFiles()
    {

        if ( file_exists(  dirname( __DIR__ )."/tmp/delete_stale_tmp_".date("Ymd") ) ) {
            return;
        }

        touch( dirname( __DIR__ )."/tmp/delete_stale_tmp_".date("Ymd") );

        $path = dirname( __DIR__ )."/tmp/";

		if( file_exists( $path ) ) {
			$dh = opendir($path);
	
	        	while ( ( $file = readdir( $dh ) ) !== false ) {
                    
                    if( $file != '.' && $file != '..' ) {

                        if( file_exists( $path."/".$file ) ) {
                            if( (time() - filemtime( $path."/".$file ) ) > ( 3600 * 24 ) ) {
                                unlink( $path."/".$file );
                            }
                        }

	        		}
	        	}
	        
			closedir($dh);
		}
    }



}
