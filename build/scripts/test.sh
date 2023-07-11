#!/usr/bin/env bash

source ${DTK_HOME}/lib/laravel.sh

COMPOSER_INSTALL_NO_DEV=0

gitlabci_prepare_composer

composer clear-cache

if [ -n "${PACKAGE_CORE_VERSION}" ]; then
  echo "Forcing tagd/core:${PACKAGE_CORE_VERSION}"
  gitlabci_composer_update_package_version "tagd/core" ${PACKAGE_CORE_VERSION}
fi

gitlabci_composer_install

composer run-script test

