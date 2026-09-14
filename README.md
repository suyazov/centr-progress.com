# Центр Прогресс

Control-plane onboarding for `centr-progress.com`.

Current capability: `php-repository`. Default task kind: `product`. Bridge may
prepare bounded PHP changes in a branch, run the repository `verify` check and
merge a reviewed PR. Delivery is disabled; DNS, deployment and every production
action remain outside this capability and require their own exact authority.
