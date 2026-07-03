import { ResponsiveContainer, BarChart, Bar, LineChart, Line, PieChart, Pie, XAxis, YAxis, CartesianGrid, Tooltip, Legend, Cell } from 'recharts';

const COLORS = ['#0088FE', '#00C49F', '#FFBB28', '#FF8042', '#8884d8', '#82ca9d'];

export function ChartRenderer({ chart, rows }) {
    if (!chart || !rows || rows.length === 0) return null;

    const { type, xAxisKey, yAxisKeys } = chart;

    // Optional: Format the data so it works better with recharts if needed
    const data = rows;

    return (
        <div style={{ width: '100%', height: 300, marginTop: '16px' }}>
            <ResponsiveContainer width="100%" height="100%">
                {type === 'bar' ? (
                    <BarChart data={data} margin={{ top: 5, right: 20, left: 0, bottom: 5 }}>
                        <CartesianGrid strokeDasharray="3 3" opacity={0.2} />
                        <XAxis dataKey={xAxisKey} tick={{fontSize: 12}} />
                        <YAxis tick={{fontSize: 12}} />
                        <Tooltip contentStyle={{ borderRadius: '8px', border: 'none', boxShadow: '0 4px 6px rgba(0,0,0,0.1)' }} />
                        <Legend wrapperStyle={{ fontSize: '12px' }} />
                        {yAxisKeys.map((key, index) => (
                            <Bar key={key} dataKey={key} fill={COLORS[index % COLORS.length]} radius={[4, 4, 0, 0]} />
                        ))}
                    </BarChart>
                ) : type === 'line' ? (
                    <LineChart data={data} margin={{ top: 5, right: 20, left: 0, bottom: 5 }}>
                        <CartesianGrid strokeDasharray="3 3" opacity={0.2} />
                        <XAxis dataKey={xAxisKey} tick={{fontSize: 12}} />
                        <YAxis tick={{fontSize: 12}} />
                        <Tooltip contentStyle={{ borderRadius: '8px', border: 'none', boxShadow: '0 4px 6px rgba(0,0,0,0.1)' }} />
                        <Legend wrapperStyle={{ fontSize: '12px' }} />
                        {yAxisKeys.map((key, index) => (
                            <Line key={key} type="monotone" dataKey={key} stroke={COLORS[index % COLORS.length]} strokeWidth={3} dot={{r: 4}} activeDot={{r: 6}} />
                        ))}
                    </LineChart>
                ) : type === 'pie' ? (
                    <PieChart>
                        <Tooltip contentStyle={{ borderRadius: '8px', border: 'none', boxShadow: '0 4px 6px rgba(0,0,0,0.1)' }} />
                        <Legend wrapperStyle={{ fontSize: '12px' }} />
                        <Pie 
                            data={data} 
                            dataKey={yAxisKeys[0]} 
                            nameKey={xAxisKey} 
                            cx="50%" 
                            cy="50%" 
                            outerRadius={100} 
                            innerRadius={60}
                            paddingAngle={5}
                            label
                        >
                            {data.map((entry, index) => (
                                <Cell key={`cell-${index}`} fill={COLORS[index % COLORS.length]} />
                            ))}
                        </Pie>
                    </PieChart>
                ) : null}
            </ResponsiveContainer>
        </div>
    );
}
