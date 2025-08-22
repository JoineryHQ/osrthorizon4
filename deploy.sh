#!/bin/bash

# Full system path to the directory containing this file, with trailing slash.
# This line determines the location of the script even when called from a bash
# prompt in another directory (in which case `pwd` will point to that directory
# instead of the one containing this script).  See http://stackoverflow.com/a/246128
MYDIR="$( cd -P "$( dirname "$(readlink -f "${BASH_SOURCE[0]}")" )" && pwd )"

function usage() {
  MYNAME=$(basename $0);
  >&2 echo "$MYNAME: deploy template files into the current Joomla site using the appropriate"
  >&2 echo "  tree structure, from $MYDIR. Must be run in the Joomla document root."
  >&2 echo "Usage: $MYNAME [templatename]"
  >&2 echo "  [templatename] (required): Name of the template; e.g. osrtandromeda, osrtstarter."
  >&2 echo "    This must match the <name> element in templateDetails.xml."
}

if [[ -z "$1" ]]; then
  usage;
  exit 1;
fi
TEMPLATENAME="$1";

if ! grep "<name>$TEMPLATENAME</name>" $MYDIR/templateDetails.xml > /dev/null; then
  >&2 echo "ERROR: $MYDIR/templateDetails.xml does not match templatename $TEMPLATENAME";
  exit 1;
fi

JROOT=`pwd`;
if [[ ! -f "$JROOT/this_is_joomla_root.txt" ]]; then
  >&2 echo "ERROR: Could not find $JROOT/this_is_joomla_root.txt"
  >&2 echo "hint: This script must be run from within the top-level docroot of a Joomla site,"
  >&2 echo "  and as a lazy verification, we just test for existence of a file named"
  >&2 echo "  this_is_joomla_root.txt in your current working directory. If you're sure"
  >&2 echo "  that your current working dir is the top-level joomla docroot, you can"
  >&2 echo "  create a file named this_is_joomla_root.txt therein, and try again."
  exit;
fi

echo "This script will deploy all template files for $TEMPLATENAME into the current joomla site."
echo "  Source: $MYDIR"
echo "  Target: $JROOT"
read -p "Are you sure you want to do that? [Strike enter to continue or Ctrl+C to exit now]"

echo "Gaining sudo privileges to chmod all joomla files writable ..."
sudo echo " ... thank you."
sudo chmod -R a+rw $JROOT;

rm -rf $JROOT/media/templates/site/$TEMPLATENAME/
mkdir -p $JROOT/media/templates/site/$TEMPLATENAME
cp -Rp $MYDIR/media/* $JROOT/media/templates/site/$TEMPLATENAME/.

rm -rf $JROOT/templates/$TEMPLATENAME
mkdir -p $JROOT/templates/$TEMPLATENAME
for i in $MYDIR/*; do
  if [[ 
    "$i" == "$MYDIR/language" 
    || "$i" == "$MYDIR/media" 
    || "$i" == "$MYDIR/deploy.sh" 
    || "$i" == "$MYDIR/package.sh" 
  ]]; then
    continue;
  fi;

  cp -Rp $i $JROOT/templates/$TEMPLATENAME/.
done

cd $MYDIR;
if [[ -d language ]]; then
  for i in `find language -type f`; do
    cp $MYDIR/$i $JROOT/$i;
  done
fi

echo "Done. Latest $TEMPLATENAME files deployed to this site."