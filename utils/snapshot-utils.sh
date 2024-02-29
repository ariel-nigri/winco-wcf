#!/bin/bash

snap_remove() {
    # find lvs mount, umount it and disconnect it.
    pid_qemu_nbd=$(pidof qemu-nbd)

    for ((i=0;i<10;i++)); do
        found=N
        for pid in $pid_qemu_nbd; do
            if grep -c /mnt/snaps/$1 /proc/${pid}/cmdline > /dev/null 2>&1; then
                echo "Waiting to umount qemu-nbd pid $pid...";
                found=Y
            fi
        done
        [ $found = N ] && break
        sleep 2
    done
    if [ $found = Y ]; then
        echo "Cannot remove the snapshot: Some qemu-nbd is still active."
        return
    fi

    umount /mnt/snaps/$1
    lvremove -y /dev/mapper/*-$1
}
##################################################################################################
snap_exists() {
    existing=$(lvs | awk '{ print $1 }')
    for lv in ${existing}; do
        [ ${lv} = "$1" ] && return 0
    done
    return 1
}
##################################################################################################
snap_create_id() {
  (
    # SHELL LOCK. only one mount at a time.
    flock 9

    snap_name=$2
    if lvs 9>&- | grep ${snap_name} > /dev/null 2>& 1 ; then
        echo "The snapshot ${snap_name} already exists" >& 2
        return 1
    fi

    /sbin/lvcreate -s -n ${snap_name} -L ${LVSIZE} $1 >/dev/null  9>&-
    if [ $? -eq 0 ]; then
        mkdir -p /mnt/snaps/${snap_name} || return 1
        mount /dev/mapper/*-${snap_name} /mnt/snaps/${snap_name} || return 1
    fi
  ) 9> /var/lock/mount-userdata.lock
  return 0
}
##################################################################################################
snap_create_new() {
  (
    # SHELL LOCK. only one mount at a time.
    flock 9

    existing=$(lvs 9>&- | awk '{ print $1 }')
    snap_name=
    for ((i=1;i<10;i++)); do
        found=0
        for lv in ${existing}; do
            if [ ${lv} = snap_${i} ]; then
                found=1
                break
            fi
        done
        if [ ${found} -eq 0 ]; then
            snap_name=snap_${i}
            break
        fi
    done

    if [ -z $snap_name ]; then
        echo "Cannot find or create a valid Snapshot" >& 2
        return 1
    fi

    /sbin/lvcreate -s -n ${snap_name} -L ${LVSIZE} $1 >/dev/null  9>&-
    if [ $? -eq 0 ]; then
        mkdir -p /mnt/snaps/${snap_name} || return
        mount /dev/mapper/*-${snap_name} /mnt/snaps/${snap_name} || return
        echo $snap_name
    fi
  ) 9> /var/lock/mount-userdata.lock
}

