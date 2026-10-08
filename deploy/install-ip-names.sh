#!/usr/bin/env bash
set -euo pipefail
repository=${1:?repository required}
revision=${2:?exact commit required}
[[ $EUID == 0 && $revision =~ ^[0-9a-f]{40}$ ]]
[[ $(git -C "$repository" rev-parse "$revision^{commit}") == "$revision" ]]
exec 9>/var/lock/kimi-projects/suyazov-centr-progress.com.lock
flock -n 9
runtime=/opt/centr-progress-ip-names
release=$runtime/releases/$revision
[[ ! -e $release && ! -e /var/lib/centr-progress-ip-names/cursor.json ]]
umask 077
install -d -m 0700 "$runtime/releases" "$release" /var/lib/centr-progress-ip-names
git -C "$repository" archive "$revision" tools/b24_ip_names.py deploy/centr-progress-ip-names.service deploy/centr-progress-ip-names.timer | tar -x -C "$release"
/usr/bin/python3 -c 'from playwright.sync_api import sync_playwright'
# Initialize the boundary before activating: all earlier records are excluded.
/usr/bin/python3 "$release/tools/b24_ip_names.py" --initialize
ln -s "$release" "$runtime/current"
install -m 0644 "$release/deploy/centr-progress-ip-names.service" /etc/systemd/system/
install -m 0644 "$release/deploy/centr-progress-ip-names.timer" /etc/systemd/system/
systemctl daemon-reload
systemctl enable --now centr-progress-ip-names.timer
printf 'timer_activated=%s\n' "$revision"
