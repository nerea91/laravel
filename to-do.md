# Pending tasks

- Make usernames in lower case unique.
- Add reserved usernames to prevent users from having conflictive usernames.
- Increment authproviders:login_count after every success login
- Delete profile permissions cache after updating/deleting a profile<->permissions relationship. It can't be done with model evens because no event is triggerred after updation or deleting from the pivot table
    Cache::forget('profile'.$this->profile_id.'permissions');
