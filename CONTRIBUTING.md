# Contributing to PHP Scaffolder

This project is maintained solo, so this file mostly documents my own workflow for consistency.

## Workflow

- Make changes in a feature branch off `main` if the change is significant.
- Use **semantic commit messages**:
  - `feat:` for new features
  - `fix:` for bug fixes
  - `docs:` for documentation changes (README, CHANGELOG, etc.)
  - `chore:` for maintenance, tooling, or script updates
- Update `CHANGELOG.md` for any release-worthy changes.
- Run any tests in `tests/` before committing.

## Code Style

- Follow PSR-12 coding standards.
- Keep code simple and readable.
- The scaffolder script should remain self-contained and easy to maintain.

## Versioning

- Follows [Semantic Versioning](https://semver.org/).
- Tag releases in Git with `vX.Y.Z` after committing code and updating the changelog.

## Notes

- No external contributors, so this is mainly a personal reference for consistent project management.
