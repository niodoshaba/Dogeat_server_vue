<?php

namespace Models;

/**
 * @author Bang
 */
class ErrorCode {

    const NoError = 0;
    const ChecksumError = 1;
    const MissingParameter = 2;
    const WrongFormat = 3;
    const AccessDeny = 4;
    const WrongParameter = 5;
    const AuthenticationFail = 6;
    const DatabaseUndefined = 7;
    const DatabaseError = 8;
    const InsufficientBalance = 9;
    const TransactionFails = 10;
    const TransactionIsFinished = 11;
    const NotFound = 404;
    const UnKnownError = 500;

}
