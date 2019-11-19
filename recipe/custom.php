<?php

namespace Deployer;

set('bin/yarn', function () {
    return run('which yarn');
});

task('yarn:install_no_copy', function () {
    run("cd {{release_path}} && {{bin/yarn}}");
});

task('artisan:cache:rebuild', function () {
    run("cd {{release_path}} && {{bin/php}} artisan cache:rebuild emojis");
});
