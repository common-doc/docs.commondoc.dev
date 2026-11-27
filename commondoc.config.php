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
            ['repository' => '/github/workspace/commondoc', 'mount' => '/'],
        ],
        'siteName'     => 'Common Doc',
        'versionLabel' => '',
    ],
];
