<?php

enum TaskState: string
{
    case PENDING = 'pending';
    case STARTED = 'started';
    case COMPLETED = 'completed';
}