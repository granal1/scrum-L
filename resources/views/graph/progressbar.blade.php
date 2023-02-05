                                    <svg
                                        width = "8mm"
                                        height = "8mm"
                                        >
                                        <circle
                                            cx = "21"
                                            cy = "15"
                                            r = "12"
                                            stroke-width = "5"
                                            fill = "none"
                                            stroke = "#aaaaff"
                                            transform = "rotate(-90 18 18)"
                                        >
                                        </circle>
                                        <circle
                                            cx = "21"
                                            cy = "15"
                                            r = "12"
                                            stroke-width = "5"
                                            fill = "none"
                                            stroke = "#0000ff"
                                            pathLength = "100"
                                            stroke-dasharray = "100"
                                            stroke-dashoffset = "{{100-$task->done_progress}}"
                                            transform = "rotate(-90 18 18)"
                                        >
                                        </circle>
                                        <text
                                            x = "15"
                                            y = "19"
                                            font-size = "11px"
                                            text-anchor = "middle"
                                        >{{$task->done_progress}}
                                        </text>
                                    </svg>
