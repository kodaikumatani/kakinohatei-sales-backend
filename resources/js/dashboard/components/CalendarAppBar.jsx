import React, { useState } from 'react';
import {alpha, AppBar, IconButton, InputBase, Popover, styled, Toolbar, Typography} from "@mui/material";
import MenuIcon from '@mui/icons-material/Menu';
import InsertInvitationIcon from "@mui/icons-material/InsertInvitation";
import {LocalizationProvider} from "@mui/x-date-pickers";
import {AdapterDayjs} from "@mui/x-date-pickers/AdapterDayjs";
import {DateCalendar} from "@mui/x-date-pickers/DateCalendar";

const Calendar = styled('div')(({ theme }) => ({
    position: 'relative',
    borderRadius: theme.shape.borderRadius,
    backgroundColor: alpha(theme.palette.common.white, 0.15),
    marginLeft: 'auto',
    width: 'auto',
}));

const InsertInvitationIconWrapper = styled('div')(({ theme }) => ({
    color: theme.palette.common.white,
    padding: theme.spacing(0, 0),
    height: '100%',
    position: 'relative',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'flex-end',
}));

const StyledInputBase = styled(InputBase)(({ theme }) => ({
    color: 'inherit',
    width: '160px',
    '& .MuiInputBase-input': {
        padding: theme.spacing(1, 0, 1, 0),
        paddingLeft: `calc(1em)`,
        transition: theme.transitions.create('width'),
        width: '100%',
    },
}));

const CalendarAppBar = (props) => {
    const { selected, setSelected } = props;
    const [anchorEl, setAnchorEl] = useState(null);
    const open = Boolean(anchorEl);
    const id = open ? 'simple-popover' : undefined;
    const handleClick = (event) => {
        setAnchorEl(event.currentTarget);
    };
    const handleClose = () => {
        setAnchorEl(null);
    };
    const handleChoose = (value) => {
        setAnchorEl(null);
        setSelected(value);
    };

    return (
        <AppBar component="static">
            <Toolbar>
                <IconButton
                    size="large"
                    edge="start"
                    color="inherit"
                    aria-label="open drawer"
                    sx={{ mr: 2 }}
                >
                    <MenuIcon />
                </IconButton>
                <Typography
                    variant="h6"
                    noWrap
                    component="div"
                >
                    ERP
                </Typography>
                <Calendar>
                    <StyledInputBase
                        value={selected.format('YYYY年MM月DD日')}
                        inputProps={{
                            'aria-label': 'calendar',
                            readOnly: true,
                        }}
                    />
                    <IconButton onClick={handleClick}>
                        <InsertInvitationIconWrapper>
                            <InsertInvitationIcon />
                        </InsertInvitationIconWrapper>
                    </IconButton>
                    <Popover
                        id={id}
                        open={open}
                        anchorEl={anchorEl}
                        onClose={handleClose}
                        anchorOrigin={{
                            vertical: 'bottom',
                            horizontal: 'left',
                        }}
                    >
                        <LocalizationProvider dateAdapter={AdapterDayjs}>
                            <DateCalendar value={selected} onChange={(newValue) => handleChoose(newValue)}/>
                        </LocalizationProvider>
                    </Popover>
                </Calendar>
            </Toolbar>
        </AppBar>
    );
}

export default CalendarAppBar;
