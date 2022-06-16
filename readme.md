# Monorepo Site Example

A prototype of an application source repository that contains source files of multiple plugin and theme dependencies that require their own build steps and tooling for development and release packaging.

Main principles:

- Use [npm workspaces](https://docs.npmjs.com/cli/v7/using-npm/workspaces) for installing, linting, testing, building and packaging local plugin and theme dependencies.

- Use Composer [local `path` dependencies](https://getcomposer.org/doc/05-repositories.md#path) for adding plugins and themes to the project-level autoload. W

Known issues:

- Composer local `path` dependencies work well for the autoload aspect but doesn't work with development related tooling which requires the `dev` dependencies for linting, running tests, etc.

- The local development environment has to be flexible enough to run the development tooling of every dependency.
