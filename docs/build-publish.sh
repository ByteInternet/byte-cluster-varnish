# compile into site/
rm -rf site
mkdocs build --clean
rm -rf site/site site/build-publish.sh site/mediawiki
for src in *.md; 
do
	title=$(basename $src .md)
	echo Converting $title.md into $title.mw
	pandoc -f markdown_github -t mediawiki $title.md -o mediawiki/$title.mw
done

echo
echo Syncing to Byte site
rsync -va --delete --exclude=mediawiki site/ byte.nl@ssh1.c1.byte.nl:byte.nl/temp/byte-varnish-cluster/
