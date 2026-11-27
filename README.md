# docs.commondoc.dev

The published documentation site for [commondoc](https://github.com/common-doc/commondoc),
served at <https://docs.commondoc.dev/>.

This repository holds the site definition and the workflow that publishes it. The
documentation itself is not kept here: the workflow checks
`common-doc/commondoc` out beside this repository and
[`commondoc.config.php`](commondoc.config.php) names that directory.

| File | What it is |
| --- | --- |
| `commondoc.config.php` | The site: its one source root, its base path, and its name |
| `.github/workflows/publish.yml` | Builds with the container action and deploys to GitHub Pages |

A build runs on every push to `main`, and on demand from the Actions tab. Nothing is
built locally, and no PHP toolchain is needed: the action runs from a container image.

## Changing the site

- **The content** comes from `docs/v1` in `common-doc/commondoc`. Edit it there. A push to
  that branch does not trigger this workflow today; re-run it here, or push here.
- **The name, the base path or the roots** are stated in `commondoc.config.php`. Every path
  in it is absolute, because the container changes directory to `/app` before it builds.
- **The theme** is the package's default. A site that replaces a template or supplies a
  stylesheet adds the `theme` section, and the files it names are published from a root, so
  they have to sit in one.

## Publishing

Pages is configured with **GitHub Actions** as its source, the custom domain
`docs.commondoc.dev`, and **Enforce HTTPS** on. The certificate is issued for that domain,
so the record `docs.commondoc.dev CNAME common-doc.github.io` has to stay in place.