<?php

declare(strict_types=1);

/*
 * The commondoc documentation site.
 *
 * The site is built by the container action, which mounts this repository at
 * `/github/workspace` and then changes directory to `/app` before it does anything. A
 * relative root therefore means a path inside the image, not inside the checkout, so
 * every path here is absolute.
 *
 * The documentation is not kept in this repository. The workflow checks the source out
 * beside this one, at `/github/workspace/commondoc`, and the root names that directory.
 * A root that resolved to nothing would build the image's own documentation and exit 0,
 * so the path is stated in full rather than left to a default.
 *
 * The site is served from a custom domain at the root of a host, so the base path is `/`.
 * It is stated once, as `view_helper_config.base_path`, because that is the value the
 * `BasePath` helper answers with when a template composes a link.
 *
 * `versions` is what makes the site follow releases rather than a branch. The build reads
 * the repository's tags and publishes one directory per major, at `/{component}/v{major}/`,
 * and the component's own address redirects to the newest of them. A patch or a minor
 * reaches the site by being tagged and by nothing else, and a pre-release never displaces a
 * release, because a stable tag outranks any candidate of the same major.
 *
 * A versioned root reads tag trees, so the workflow has to fetch the tags. A shallow
 * single-branch clone carries none, and the build would publish no version at all.
 */

use CommonDoc\Output\PathType;
use CommonDoc\SiteConfig;

return [
    'view_helper_config' => [
        'base_path' => '/',
    ],
    SiteConfig::class      => [
        'pathType'     => PathType::Directory,
        'output'       => '/github/workspace/build',
        'target'       => 'docs/v1',
        'roots'        => [
            [
                'repository' => '/github/workspace/commondoc',
                // Each tag is read from its own major's directory, so a version is
                // published from the release that wrote it and a future major needs no
                // change here.
                'versions'   => true,
                'target'     => ['docs/v{major}'],
            ],
        ],
        'siteName'     => 'Common Doc',
        'versionLabel' => '',
    ],
];
