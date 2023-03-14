#!/usr/bin/env bash

source ${DTK_HOME}/lib/helm.sh

NAMESPACE=tagd

if [[ ${ENV} == "production" ]]; then
  image_tag=${CI_COMMIT_TAG}
  release="res-api"
  kube_config=${KUBE_CONFIG_PROD}
else
  image_tag="${ENV}-${CI_PIPELINE_ID}"
  release="res-api-${ENV}"
  kube_config=${KUBE_CONFIG_UAT}
  env_secres="res-api-env-${ENV}"
  migrations_secres="res-api-env-${ENV}"
fi

set_chart_values () {
  # images
  set_chart_value image.apiProxy "${CI_REGISTRY_IMAGE}/proxy:${image_tag}"
  set_chart_value image.api "${CI_REGISTRY_IMAGE}/phpfpm:${image_tag}"

  # secress
  set_chart_value imagePullSecres.api "gitlab-pull-secres"

  # hosts
  set_chart_value host.api ${HOST}

  # secress
  set_chart_value secres.api.env ${env_secres}
  set_chart_value secres.api.migrationsEnv ${migrations_secres}

  # replica counts
  set_chart_value replicas.api ${REPLICAS}
  set_chart_value replicas.apiProxy ${REPLICAS}

  # other
  set_chart_value env ${ENV}
  set_chart_value jobId ${CI_JOB_ID}

  # run migrations
  set_chart_value migrations.run false
}

deploy () {
  export KUBECTRL_CONFIG=${kube_config}
  export HELM_CHART_REPO=${HELM_CHART_REPO}

  if ! helm_deploy "${release}" ${NAMESPACE}; then
    exit 1
  fi

  echo "--------------------------------------------------------------------------------------------"
  echo "Deployed to ${ENV}:"
  echo "--------------------------------------------------------------------------------------------"
  echo " * https://${HOST}"
  echo "--------------------------------------------------------------------------------------------"
}

set_chart_values

deploy
