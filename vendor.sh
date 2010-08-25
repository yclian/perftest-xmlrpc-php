#!/bin/bash
# ------------------------------------------------------------------------------
# Grab the vendors.
# 
# Usage: ./vendor.sh [vendor_dir]
#
# Author: yclian
# Since: 20100824
# Version: 20100824
# ------------------------------------------------------------------------------

if [ -n "$1" ]
    then
	VENDOR_DIR="$1"
    else
	VENDOR_DIR="$(dirname $0)/vendor"
fi

mkdir -p $VENDOR_DIR
rm -rf $VENDOR_DIR/*

svn co http://php-ixr.googlecode.com/svn/trunk $VENDOR_DIR/IXR

git clone git://github.com/zendframework/zf2.git $VENDOR_DIR/Zend

svn co http://svn.php.net/repository/pear/packages/XML_RPC2/trunk $VENDOR_DIR/XML_RPC2

svn co https://phpxmlrpc.svn.sourceforge.net/svnroot/phpxmlrpc/trunk $VENDOR_DIR/PHP-XMLRPC

