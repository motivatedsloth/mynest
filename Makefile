#for creating tags files
TAG_SOURCES=mynest vendor
#create list of tags file names
TAGS=$(foreach tg,$(TAG_SOURCES),.tags.$(tg))

.PHONY: $(TAG_SOURCES) refresh init

#install packages
init: vendor/autoload.php tags

refresh: clear-tag-mynest tags

vendor/autoload.php: composer.json 	
	composer install 
	rm -f .tags.vendor

tags: $(TAGS)

.tags.%: 
	ctags -f $@ -R $*

clear-tag-%:
	rm -f .tags.$*

