#!/bin/bash

# Full system path to the directory containing this file, with trailing slash.
# This line determines the location of the script even when called from a bash
# prompt in another directory (in which case `pwd` will point to that directory
# instead of the one containing this script).  See http://stackoverflow.com/a/246128
MYDIR="$( cd -P "$( dirname "$(readlink -f "${BASH_SOURCE[0]}")" )" && pwd )"

JROOT=`pwd`;

function usage() {
  MYNAME=$(basename $0);
  >&2 echo "$MYNAME: copy template files from the current Joomla site to the appropriate"
  >&2 echo "  tree structure in in $MYDIR. Must be run in the Joomla document root."
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

if [[ ! -f "$JROOT/this_is_joomla_root.txt" ]]; then
  >&2 echo "ERROR: Could not find $JROOT/this_is_joomla_root.txt"
  >&2 echo "Hint: This script must be run from within the top-level docroot of a Joomla site,"
  >&2 echo "  and as a lazy verification, we just test for existence of a file named"
  >&2 echo "  this_is_joomla_root.txt in your current working directory. If you're sure"
  >&2 echo "  that your current working dir is the top-level joomla docroot, you can"
  >&2 echo "  create a file named this_is_joomla_root.txt therein, and try again."
  exit 1;
fi

if [[ -n $(git -C $MYDIR status --porcelain) ]]; then
  >&2 echo "ERROR: master repo $MYDIR has uncommitted changes and/or untracked files."
  >&2 echo "Hint: We want to be careful about overwriting uncommited changes, so"
  >&2 echo "  we're quiting here. You can try again after you add, commit, or ignore"
  >&2 echo "  all files in the repo."
  exit 1;
fi

if [[ -n $(git -C $MYDIR status --porcelain) ]]; then
  >&2 echo "ERROR: master repo $MYDIR has uncommitted changes and/or untracked files."
  >&2 echo "Hint: We want to be careful about overwriting uncommited changes, so"
  >&2 echo "  we're quiting here. You can try again after you add, commit, or ignore"
  >&2 echo "  all files in the repo."
  exit 1;
fi

echo "This script will copy all template files for $TEMPLATENAME from the current joomla site into the master repo."
echo "  Source: $JROOT"
echo "  Target: $MYDIR"
read -p "Are you sure you want to do that? [Strike enter to continue or Ctrl+C to exit now]"

rm -rf $MYDIR/media
mkdir $MYDIR/media
cp -R $JROOT/media/templates/site/$TEMPLATENAME/* $MYDIR/media/.

for i in $MYDIR/*; do
  if [[
    "$i" == "$MYDIR/language"
    || "$i" == "$MYDIR/media"
    || "$i" == "$MYDIR/deploy.sh"
    || "$i" == "$MYDIR/package.sh"
    || "$i" == "$MYDIR/.git"
    || "$i" == "$MYDIR/nbproject"
  ]]; then
    continue;
  fi;
  rm -rf $i;
  cp -R $JROOT/templates/$TEMPLATENAME/* $MYDIR
done


rm -rf $MYDIR/language;
for i in `find language -type f -name "*$TEMPLATENAME*"`; do
  LANGDIRNAME=$(dirname $i);
  mkdir -p $MYDIR/$LANGDIRNAME;
  cp $JROOT/$i $MYDIR/$i;
done

echo "Done. Joomla $TEMPLATENAME template files packaged to $MYDIR"