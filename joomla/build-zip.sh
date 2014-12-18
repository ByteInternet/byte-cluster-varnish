#!/bin/bash

set -e

PROJ=`basename $PWD`
cd packages/
zip -r com_terebinth com_terebinth/
zip -r plg_content_terebinth plg_content_terebinth/
zip -r plg_user_terebinth plg_user_terebinth/
cd ../..
zip -r $PROJ $PROJ/packages/*.zip $PROJ/{*.xml,LICENSE}
cd $PROJ
rm packages/*.zip
mv ../$PROJ.zip .
