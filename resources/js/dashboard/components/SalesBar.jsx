import React from 'react';
import { BarChart, Bar, XAxis, YAxis, CartesianGrid, ResponsiveContainer } from 'recharts';

const SalesBar = props => {
  const { hours } = props;

  return (
    <ResponsiveContainer aspect='2'>
      <BarChart
        data={hours}
        margin={{ top: 30, right: 10, bottom: 0, left: -20 }}
        barCategoryGap={'20%'}
      >
        <CartesianGrid horizontal={true} vertical={false} />
        <Bar dataKey='value' fill='#1492C9' label={{ position: 'top' }} />
        <XAxis
          dataKey='hour'
          type='number'
          interval={0}
          domain={['dataMin - 1', 'dataMax + 1']}
          ticks={[10, 11, 12, 13, 14, 15, 16, 17, 18, 19]}
        />
        <YAxis />
      </BarChart>
    </ResponsiveContainer>
  );
};
export default SalesBar;
