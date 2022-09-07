export const SCOPE = {
    oracle_database: { key: 'oracle_database', text: 'Oracle Database' },
    oracle_apps: { key: 'oracle_apps', text: 'Oracle Apps' },
    microsoft: { key: 'microsoft', text: 'Microsoft' },
    vmware: { key: 'vmware', text: 'Vmware' },
    sap: { key: 'sap', text: 'Sap' }
};

export const SCOPE_OPTIONS = [
    { item: 'oracle_database', name: 'Oracle Database' },
    { item: 'oracle_apps', name: 'Oracle Apps' },
    { item: 'microsoft', name: 'Microsoft' },
    { item: 'vmware', name: 'Vmware' },
    { item: 'sap', name: 'Sap' },
];

export const SCOPE_STAGES = [
    {
        key: 'oracle_database', stages: [
            { name: "Pre-Engagement Questionaire" },
            { name: "Data Collection" },
            { name: "Data Review" },
            { name: "Right Sizing" },
            { name: "Right Costing" },
            { name: "TCO Calculation" },
            { name: "Report Preparation" },
            { name: "Report Presentation - Draft" },
            { name: "Report Review" },
            { name: "Report Presentation - Final" },
            { name: "Final Submission & Sign-off" },
        ]
    },
];

