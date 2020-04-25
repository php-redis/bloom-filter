<?php
namespace xming\filters;

class Commands
{
    /** Bloom Filter Commands */
    const BF_RESERVE = 'BF.RESERVE';
    const BF_ADD = 'BF.ADD';
    const BF_MADD = 'BF.MADD';
    const BF_INSERT = 'BF.INSERT';
    const BF_EXISTS = 'BF.EXISTS';
    const BF_MEXISTS = 'BF.MEXISTS';
    const BF_SCANDUMP = 'BF.SCANDUMP';
    const BF_LOADCHUNK = 'BF.LOADCHUNK';
    const BF_INFO = 'BF.INFO';
}