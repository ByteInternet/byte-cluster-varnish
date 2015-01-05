# compile into site/
mkdocs build --clean
for src in *.md; 
do
	title=$(basename $src .md)
	echo Converting $title.md into $title.mw
	pandoc -f markdown_github -t mediawiki $title.md -o $title.mw
done

echo
echo Syncing to Byte site
rsync -va site/ byte.nl@ssh1.c1.byte.nl:byte.nl/temp/byte-varnish-cluster/
