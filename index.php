<?php
// booking.php - Main entry point for the hotel booking system
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.22.0/tabler-icons.min.css">

    <!-- External Dependencies -->
    <!-- React 18 Core Libraries -->
    <script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>

    <!-- Babel for JSX compilation -->
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

    <!-- Date manipulation library -->
    <script src="https://unpkg.com/dayjs@1.11.10/dayjs.min.js"></script>

    <!-- Ant Design UI Framework -->
    <link href="https://unpkg.com/antd@5.22.2/dist/reset.css" rel="stylesheet">
    <link href="https://unpkg.com/antd@5.22.2/dist/antd.css" rel="stylesheet">
    <script src="https://unpkg.com/antd@5.22.2/dist/antd.min.js"></script>

    <!-- Tailwind CSS for utility classes -->
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Custom Styles -->
    <style type="text/css">
        /* Animation for room cards */

        :root {
            --primary-color: #F9F4EE;
            --secondary-color: #EDE7E0;
            --accent-color: #F6F6F6;
            --dark-accent-color: #4E381A;
        }

        .hero-banner {
            height: 50vh;
            background: url("http://ubicompsystem.no-ip.org:88/site/ally/wp-content/uploads/2024/09/ally-hero.jpg");
            background-size: cover;
            background-position: center;
            border-radius: 10px;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .room-card {
            transition: transform 0.2s;
        }

        .room-card:hover {
            transform: translateY(-5px);
        }

        /* Carousel navigation adjustment */
        .ant-carousel .slick-prev,
        .ant-carousel .slick-next {
            offset: -10px;
        }

        .hero-banner {
            position: relative;
        }

        .hero-banner p {
            z-index: 2;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }


        .ant-pagination-item-active,
        .ant-pagination .ant-pagination-item-active a {
            border-color: var(--primary-color) !important;
            color: var(--primary-color) !important;
        }

        .btn,
        .btn span {
            background-color: var(--dark-accent-color) !important;
            color: #fff !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
    </style>
</head>

<body>
    <!-- Root container for React application -->
    <div id="booking-app"></div>

    <script type="text/babel">
        const App = () => {
            const { Card, Button, DatePicker, InputNumber, Typography, message, Layout, Space, Divider,Carousel ,Select ,Pagination, Badge ,ConfigProvider ,Input } = window.antd;
            const { Search } = Input; 
            const { RangePicker } = DatePicker;
            const { Title, Text } = Typography;
            const { Content } = Layout;

            const [rooms, setRooms] = React.useState([]);
        

            const [selectedRoom, setSelectedRoom] = React.useState(null);
            const [dates, setDates] = React.useState(null);
            const [guests, setGuests] = React.useState({ adults: 1, children: 0 });
            const [total, setTotal] = React.useState(0);

            // Loading state
            const [loading, setLoading] = React.useState(true);
            // Pagination
            const [currentPage, setCurrentPage] = React.useState(1);
            const [pageSize, setPageSize] = React.useState(3);
            const [totalRooms, setTotalRooms] = React.useState(0);
            const [searchQuery, setSearchQuery] = React.useState('');

            React.useEffect(() => {
                setTimeout(() => {
                    const allRooms = [
                        {
                            id: 1,
                            name: 'Deluxe Room',
                            price: 150,
                            description: 'Spacious room with city view',
                            images: [
                                'https://img.freepik.com/free-photo/3d-rendering-luxury-bedroom-suite-resort-hotel-with-twin-bed-living_105762-2018.jpg?t=st=1735447253~exp=1735450853~hmac=3218636c3c370f19ac4451eec9fb83c64a97278246254da7f450901a751e8101&w=2000',
                                'https://img.freepik.com/free-photo/luxury-bedroom-hotel_1150-10836.jpg?t=st=1735447798~exp=1735451398~hmac=2d3b515db2f0adbe83a00ceaf86a83b29df6bb77c45fd7aebeea27430c5049c9&w=2000'
                            ],
                            amenities: [
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/wifi.svg', label: 'Free WiFi' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/device-tv.svg', label: 'Smart TV' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/wind.svg', label: 'Air Conditioning' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/coffee.svg', label: 'Coffee Maker' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/bath.svg', label: 'Private Bath' }
                            ]
                        },
                        {
                            id: 2,
                            name: 'Executive Suite',
                            price: 250,
                            description: 'Luxury suite with ocean view',
                            images: [
                                'https://img.freepik.com/free-photo/bangkok-thailand-august-12-2016-beautiful-luxury-bedroom-int_1203-2724.jpg?t=st=1735447420~exp=1735451020~hmac=e917c15ffdb3cbb2550311f5e681735effed8c8260d699e78dd32163fb58bc17&w=2000',
                                'https://img.freepik.com/free-photo/tidy-hotel-room-with-brown-curtains_1203-1493.jpg?t=st=1735447442~exp=1735451042~hmac=6fd7b1c13a7f37ba95682742a28ca24402708db4106755e86ba29174ba3d4197&w=2000',
                                'https://img.freepik.com/free-photo/elegant-hotel-room-with-big-bed_1203-1494.jpg?t=st=1735447465~exp=1735451065~hmac=1d06fe9a85351395a168863fe0af803150383692eb6f78648c5f97335456bb0e&w=2000',
                            ],
                            amenities: [
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/wifi.svg', label: 'Free WiFi' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/device-tv.svg', label: 'Smart TV' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/wind.svg', label: 'Air Conditioning' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/coffee.svg', label: 'Coffee Maker' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/bath.svg', label: 'Private Bath' }
                            ]
                        },
                        {
                            id: 3,
                            name: 'Family Room',
                            price: 200,
                            description: 'Perfect for families',
                            images: [
                                'https://img.freepik.com/free-photo/3d-rendering-beautiful-comtemporary-luxury-bedroom-suite-hotel-with-tv_105762-2152.jpg?t=st=1735447515~exp=1735451115~hmac=312a454218c0ade23df03fc9fb9e2ca5e79725dd28db9c3324b893ef1105c4a0&w=2000',
                                'https://img.freepik.com/premium-photo/3d-rendering-beautiful-comtemporary-luxury-bedroom-suite-hotel-with-tv_105762-2151.jpg?w=2000',
                                'https://img.freepik.com/free-photo/3d-rendering-beautiful-luxury-bedroom-suite-hotel-with-tv-chandelier_105762-2156.jpg?t=st=1735447755~exp=1735451355~hmac=3d77e5495de82b7c236355e32688395e3780dfd3dc517d52391b869c940cac45&w=2000'
                            ],
                            amenities: [
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/wifi.svg', label: 'Free WiFi' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/device-tv.svg', label: 'Smart TV' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/wind.svg', label: 'Air Conditioning' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/coffee.svg', label: 'Coffee Maker' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/bath.svg', label: 'Private Bath' }
                            ]
                        },
                        {
                            id: 4,
                            name: 'Ocean View Suite',
                            price: 300,
                            description: 'Luxury suite with panoramic ocean view',
                            images: [
                                'https://img.freepik.com/free-photo/3d-rendering-beautiful-comtemporary-luxury-bedroom-suite-hotel-with-tv_105762-2071.jpg?t=st=1735447543~exp=1735451143~hmac=1dd5fe2f6bc4b6d6490584501483bb802a9f1f9e1c23c4bc1be0ab00d9521675&w=2000',
                                'https://img.freepik.com/free-photo/3d-rendering-beautiful-comtemporary-luxury-bedroom-suite-hotel-with-tv_105762-2065.jpg?t=st=1735447559~exp=1735451159~hmac=d882b2e97ceeb5f12f360fa4c38ca294544c8ad5bed5f0f9b0b7034fbafce59d&w=2000',
                            ],
                            amenities: [
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/wifi.svg', label: 'Free WiFi' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/device-tv.svg', label: 'Smart TV' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/wind.svg', label: 'Air Conditioning' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/coffee.svg', label: 'Coffee Maker' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/bath.svg', label: 'Private Bath' }
                            ]
                        },
                        {
                            id: 5,
                            name: 'Penthouse Suite',
                            price: 500,
                            description: 'Ultimate luxury experience',
                            images: [
                                'https://img.freepik.com/premium-photo/minsk-belarus-september-2019-interior-modern-luxure-bedroom-studio-apartments-elite-hotel_97694-8262.jpg?w=2000',
                                'https://img.freepik.com/premium-photo/minsk-belarus-september-2019-interior-modern-luxure-bedroom-studio-apartments-elite-hotel_97694-8255.jpg?w=2000',
                                'https://img.freepik.com/premium-photo/minsk-belarus-september-2019-interior-modern-luxure-bedroom-studio-apartments-elite-hotel_97694-8271.jpg?w=2000',
                            ],
                            amenities: [
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/wifi.svg', label: 'Free WiFi' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/device-tv.svg', label: 'Smart TV' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/wind.svg', label: 'Air Conditioning' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/coffee.svg', label: 'Coffee Maker' },
                                { icon: 'https://unpkg.com/@tabler/icons@3.22.0/icons/outline/bath.svg', label: 'Private Bath' }
                            ]
                        }
                    ];
                    
                    setTotalRooms(allRooms.length);
                    
                    // Calculate pagination
                    const startIndex = (currentPage - 1) * pageSize;
                    const paginatedRooms = allRooms.slice(startIndex, startIndex + pageSize);
                    
                    setRooms(paginatedRooms);
                    setLoading(false);
                }, 2000);
            }, [currentPage, pageSize]);

         

            const calculateTotal = React.useCallback(() => {
                if (!selectedRoom || !dates) return 0;
                const nights = dates[1].diff(dates[0], 'days');
                return selectedRoom.price * nights;
            }, [selectedRoom, dates]);

            React.useEffect(() => {
                setTotal(calculateTotal());
            }, [selectedRoom, dates, calculateTotal]);

            const handleBooking = async (e) => {
                e.preventDefault();
                if (!selectedRoom || !dates) {
                    message.error('Please select room and dates');
                    return;
                }

                const bookingData = {
                    roomId: selectedRoom.id,
                    checkIn: dates[0].format('YYYY-MM-DD'),
                    checkOut: dates[1].format('YYYY-MM-DD'),
                    guests: guests,
                    total: total
                };

                try {
                    const response = await fetch('api/process-booking.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(bookingData)
                    });

                    if (response.ok) {
                        message.success('Booking successful!');
                    } else {
                        throw new Error('Booking failed');
                    }
                } catch (error) {
                    message.error('Error processing booking');
                }
            };

            const handlePaginationChange = (page, pageSize) => {
                setCurrentPage(page);
                setPageSize(pageSize);
            };

            const handleSearch = (e) => {
                setSearchQuery(e.target.value);
            };

            const filteredRooms = rooms.filter(room =>
                room.name.toLowerCase().includes(searchQuery.toLowerCase())
            );

            return (
                <ConfigProvider
                    theme={{
                        components: {
                            Input: {
                                colorBorder: 'var(--dark-accent-color)',
                                colorPrimary: 'var(--dark-accent-color)',
                                colorBackground: 'var(--secondary-color)',
                                colorPrimaryHover: 'var(--dark-accent-color)',
                            },
                            Pagination: {
                                itemActiveBg: 'var(--dark-accent-color)', 
                                itemActiveBorderColor: 'var(--dark-accent-color)',
                                itemActiveFontColor: '#ffffff', 
                            },

                            Button:{
                                colorPrimary: 'var(--dark-accent-color)', // Background color
                                colorPrimaryBorder: 'var(--dark-accent-color)', // Border color
                                colorPrimaryHover: 'var(--dark-accent-color)', // Hover background color
                                colorPrimaryActive: 'var(--dark-accent-color)', // Active background color
                                defaultBg: 'var(--dark-accent-color)',
                                primaryColor:"#ffffff"
                            }
                        }
                    }}
                >
                    <Layout className="min-h-screen bg-[color:--primary-color] color-[color:--dark-accent-color]">
                        <Content className="p-6">
                            <div className="max-w-7xl mx-auto">
                                <div className="hero-banner mb-8 flex flex-col justify-center items-center gap-4">
                                    <p className="text-4xl font-bold text-white">Hotel Room Booking</p>
                                    <Button type="primary" size="large" className="mt-4 btn" href="#rooms">
                                        Explore Rooms
                                    </Button>
                                </div>


                                    
                                <div id="rooms" className="grid grid-cols-5 gap-10">
                                    <div className="col-span-5 md:col-span-3 flex flex-col gap-6 mb-8">
                                        <div className="mb-4">
                                            <Search
                                                placeholder="Search rooms by name..."
                                                value={searchQuery}
                                                onChange={handleSearch}
                                                className="w-full"
                                                size="large"
                                                enterButton 
                                            />
                                        </div>
                                        {filteredRooms.map(room => (
                                            <Card
                                                key={room.id}
                                                hoverable
                                                className="room-card bg-[color:--secondary-color]"
                                            >
                                                <div className="flex flex-row gap-5">
                                                    <div className="w-1/3 rounded overflow-hidden h-full">
                                                        <Carousel arrows  dots={false} draggable infinite autoplay  className=" h-full">
                                                            {room.images.map((image, index) => (
                                                                <div key={index}>
                                                                    <img 
                                                                        src={image} 
                                                                        alt={`${room.name} ${index + 1}`}
                                                                        className="w-full h-full object-cover"
                                                                    />
                                                                </div>
                                                            ))}
                                                        </Carousel>
                                                    </div>
                                                    <div className="w-2/3">

                                                        <Card.Meta
                                                            title={room.name}
                                                            description={room.description}
                                                        />
                                                        <div className="mt-4">
                                                            <Text strong className="text-sm">Amenities: </Text>
                                                            <div className="flex flex-wrap gap-3 mt-2">
                                                                {room.amenities.map((amenity, index) => (
                                                                    <div key={index} className="flex items-center gap-1 rounded-full bg-[color:--accent-color] px-2 ">
                                                                        <img src={amenity.icon} className="w-4 h-4 opacity-[.6]" />

                                                                        <span className="text-[14px] text-gray-600">{amenity.label}</span>
                                                                    </div>
                                                                ))}
                                                            </div>
                                                        </div>
                                                        <Divider />
                                                        <div className="flex justify-between items-center">
                                                            <Text strong>
                                                                <span className="text-2xl font-bold">${room.price}</span>
                                                                /night
                                                            </Text>
                                                            <Button 
                                                                type={selectedRoom?.id === room.id ? 'primary' : 'default'}
                                                                onClick={() => setSelectedRoom(room)}
                                                                className="btn"
                                                            >
                                                                {selectedRoom?.id === room.id ? 'Selected' : 'Select Room'}
                                                            </Button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </Card>
                                        ))}

                                        {totalRooms > 3 && (
                                            <div className="flex justify-center mt-6">
                                                <Pagination
                                                    current={currentPage}
                                                    pageSize={pageSize}
                                                    total={totalRooms}
                                                    onChange={handlePaginationChange}
                                                    showSizeChanger={false}
                                                />
                                            </div>
                                        )}
                                </div>
                                
                                <div className="flex flex-col gap-5 col-span-5 md:col-span-2">
                                        <Card className=" bg-[color:--secondary-color]">

                                            <form onSubmit={handleBooking}>
                                                <Space direction="vertical" className="w-full h-auto">
                                                    <div>
                                                        <Text strong>Select Dates</Text>
                                                        <RangePicker 
                                                            className="w-full"
                                                            onChange={setDates}
                                                            format="YYYY-MM-DD"
                                                        />
                                                    </div>

                                                    <div className="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <Text strong>Adults</Text>
                                                            <Select
                                                                defaultValue="1"
                                                                style={{ width: "100%" }}
                                                                options={[
                                                                    {
                                                                        value: "1",
                                                                        label: "1",
                                                                    },
                                                                    {
                                                                        value: "2",
                                                                        label: "2",
                                                                    },
                                                                    {
                                                                        value: "3",
                                                                        label: "3",
                                                                    },
                                                                    {
                                                                        value: "4",
                                                                        label: "4",
                                                                    },
                                                                ]}
                                                            />
                                                        </div>
                                                        <div>
                                                            <Text strong>Children</Text>
                                                            <Select
                                                                defaultValue="0"
                                                                style={{ width: "100%" }}
                                                                options={[
                                                                    {
                                                                        value: "0",
                                                                        label: "0",
                                                                    },
                                                                    {
                                                                        value: "1",
                                                                        label: "1",
                                                                    },
                                                                    {
                                                                        value: "2",
                                                                        label: "2",
                                                                    },
                                                                    {
                                                                        value: "3",
                                                                        label: "3",
                                                                    },
                                                                ]}
                                                            />
                                                        </div>
                                                    </div>

                                                    {selectedRoom && dates && (
                                                        <Card className="bg-[color:--accent-color]">
                                                            <Title level={4}>Booking Summary</Title>
                                                            <p>Room: {selectedRoom.name}</p>
                                                            <p>Total Nights: {dates[1].diff(dates[0], 'days')}</p>
                                                            <p>Total Amount: ${total}</p>
                                                        </Card>
                                                    )}

                                                    <Button 
                                                        type="primary" 
                                                        htmlType="submit"
                                                        disabled={!selectedRoom || !dates}
                                                        className="w-full btn mt-4"
                                                    >
                                                        Book Now
                                                    </Button>
                                                </Space>
                                            </form>
                                        </Card>

                                        
                                    </div>
                                </div>
                            </div>
                        </Content>
                    </Layout>
                </ConfigProvider>
            );
        };

        const root = ReactDOM.createRoot(document.getElementById('booking-app'));
        root.render(<App />);
    </script>
</body>

</html>