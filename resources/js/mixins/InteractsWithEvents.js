export default {
    props: ['resourceName', 'resourceId', 'field'],

    methods: {
        /*
        * Check if value is event.
        */
        isEvent(value) {
            return _.includes([
                'retrieved', 'creating', 'created', 'updating', 'updated',
                'saving', 'saved', 'restoring', 'restored', 'replicating',
                'deleting', 'deleted', 'forceDeleted',
            ], value);
        },
    },
}