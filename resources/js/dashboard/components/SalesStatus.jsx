import React, { useEffect, useState } from "react";
import PropTypes from 'prop-types';
import axios from "axios";
import {Box, Paper, Tab, Tabs, Typography} from "@mui/material";
import SalesTable from "./SalesTable";

function TabPanel(props) {
    const { children, value, index, ...other } = props;

    return (
        <div
            role="tabpanel"
            hidden={value !== index}
            id={`simple-tabpanel-${index}`}
            aria-labelledby={`simple-tab-${index}`}
            {...other}
        >
            {value === index && (
                <Box sx={{ pt: 1 }}>
                    <Typography>{children}</Typography>
                </Box>
            )}
        </div>
    );
}

TabPanel.propTypes = {
    children: PropTypes.node,
    index: PropTypes.number.isRequired,
    value: PropTypes.number.isRequired,
};

function a11yProps(index) {
    return {
        id: `simple-tab-${index}`,
        'aria-controls': `simple-tabpanel-${index}`,
    };
}

const SalesStatus = (props) => {
    const { date } = props;
    const [value, setValue] = React.useState(0);
    const [store, setStore] = useState([]);

    useEffect(() => {
        axios.get(`/api/${date}/stores`)
            .then(response => setStore(response.data.summary))
            .catch(error => console.log(error))
    }, [date]);

    const handleChange = (event, newValue) => {
        setValue(newValue);
    };

    return (
        <Paper
            sx={{
                p: 2,
                pt: 1,
                display: 'flex',
                flexDirection: 'column',
                minHeight: '270px',
            }}
        >
            <Box>
                <Tabs
                    value={value}
                    onChange={handleChange}
                    variant="scrollable"
                    scrollButtons="auto"
                    aria-label="scrollable auto tabs example"
                >
                    <Tab label="All" {...a11yProps(0)} />
                    {store.map((entry, index) => (
                        <Tab label={entry.name} {...a11yProps(index+1)} />
                    ))}
                </Tabs>
            </Box>
            <TabPanel value={value} index={0}>
                <SalesTable date={date} query={''} />
            </TabPanel>
            {store.map((entry, index) => (
                <TabPanel value={value} index={index+1}>
                    <SalesTable date={date} query={`?store_id=${entry.store_id}`}/>
                </TabPanel>
            ))}
        </Paper>
    );
}

export default SalesStatus;
