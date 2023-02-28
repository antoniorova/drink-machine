all: help
.PHONY: drink test infection check-all cs-check cs-fix rector-check rector inspect pslam
current_dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
docker_composer_cmd := @docker run -v $(current_dir):/data -w /data -it composer composer install --prefer-dist && composer $1
help: Makefile
	@sed -n 's/^##//p' $<

## —— COFFEE MACHINE TOOLS  🛠 —————————————————————————————————————————————————————————————————————————————
## drink:				Get a drink from Coffee Machine (send order using COMMAND="H:1:0 0.5 --extra-hot")
drink:
	@docker run -v $(current_dir):/data -w /data \
		-it composer composer install --prefer-dist --optimize-autoloader \
		&& bin/console drink:maker $(COMMAND)

## —— Tests ✅ —————————————————————————————————————————————————————————————————————————————————————————

## test: 				Launch tests suite
test:
	$(docker_composer_cmd) test

## infection: 			Launch infection checks to get uncovered code
infection:
	$(docker_composer_cmd) infection

## —— Coding standards ✨ ——————————————————————————————————————————————————————————————————————————————

## check-all:		 	Launch test, php_codesniffer to check style and run static code analysis
check-all:
	$(docker_composer_cmd) check-all

## cs-check:		 	Launch php_codesniffer to check style
cs-check:
	$(docker_composer_cmd) cs-check

## cs-fix:		 	Fix code style
cs-fix:
	$(docker_composer_cmd) cs-fix

## rector-check:		 	Launch rector to check style
rector-check:
	$(docker_composer_cmd) rector-check

## rector:		 	Launch rector to refactor code
rector:
	$(docker_composer_cmd) rector

## inspect:		 	Run phpstan static code analysis
inspect:
	$(docker_composer_cmd) inspect

## pslam:				Run pslam static code analysis
pslam:
	$(docker_composer_cmd) pslam
