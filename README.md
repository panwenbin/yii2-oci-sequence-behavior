### OciSequenceBehavior
> This is usefull when an Oracle sequence not set with a trigger. Add the behavior, the primary key will be set to SEQUENCE.NEXTVAL.

### Usage
Add this behavior to oci ActiveRecord model
```
public function behaviors()
{
    return [
        [
            'class' => OciSequenceBehavior::className(),
            'sequenceName' => 'SOME_SEQ',
        ],
    ];
}
```